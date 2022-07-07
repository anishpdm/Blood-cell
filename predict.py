from flask import Flask, render_template, url_for, request, jsonify

import numpy as np 
import cv2 




app = Flask(__name__)


@app.route("/predict")
def image():
    image = cv2.imread('./uploads/testimage.jpg')

    # Convert it to HSV Color Map
    img = cv2.cvtColor(image, cv2.COLOR_BGR2HSV)

    # Set the thresholds for RBC Detection
    rlower = np.array([160, 60, 100])
    rupper = np.array([180, 200, 255])

    # Find the colors within the specified boundaries and apply the mask
    rmask = cv2.inRange(img, rlower, rupper)

    # Find the contours
    rcontours, hierarchy = cv2.findContours(rmask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)[-2:]

    # Count the number of RBC's
    rbc_count = 0
    rbc = []
    multiple_cells = []
    for contour in rcontours:
        a = cv2.contourArea(contour) 
        if a > 75 and a <= 300:
            rbc.append(contour)
            rbc_count += 1
        elif a > 300:
            multiple_cells.append(contour)
            if a <= 600:
                rbc_count += 2
            else:
                rbc_count += 3

    # Print the count 
    print(f'Approximate number of RBC: {rbc_count}')

    # Segment the RBC's
    cv2.drawContours(image, multiple_cells, -1, (0, 0, 255), 3)
    cv2.drawContours(image, rbc, -1, (0, 0, 255), 3)


    # Set the thresholds for WBC Detection
    wlower = np.array([120, 50, 20])
    wupper = np.array([140, 255, 255])

    # Find the colors within the specified boundaries and apply the mask
    wmask = cv2.inRange(img, wlower, wupper)

    # Find the contours
    wcontours, hierarchy = cv2.findContours(wmask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)[-2:]

    # Count and segment the WBC's
    cv2.drawContours(image, wcontours, -1, (255, 0, 0), 3)
    wbc_count = len(wcontours)

    # Print the count
    print(f'Approximate number of WBC: {wbc_count}')

    # Write the output in a file
    cv2.imwrite('op.jpg', image)
    

    return jsonify({"rbc": rbc_count, "wbc": wbc_count})


if __name__ == "__main__":
    app.debug = True
    app.run(host="0.0.0.0", port=4000)
