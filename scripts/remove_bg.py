from PIL import Image

def remove_white_background(input_path, output_path, tolerance=40):
    img = Image.open(input_path).convert("RGBA")
    datas = img.getdata()

    new_data = []
    for item in datas:
        # Check if the pixel is white-ish
        if item[0] >= 255 - tolerance and item[1] >= 255 - tolerance and item[2] >= 255 - tolerance:
            new_data.append((255, 255, 255, 0)) # Make transparent
        else:
            new_data.append(item)

    img.putdata(new_data)
    img.save(output_path, "PNG")

if __name__ == "__main__":
    remove_white_background("c:\\laragon\\www\\NIMS\\public\\images\\ncf-logo.jpg", "c:\\laragon\\www\\NIMS\\public\\images\\ncf-logo.png", tolerance=40)
