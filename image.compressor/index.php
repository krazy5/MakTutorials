<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Compressor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            padding: 20px;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        input, button {
            margin: 10px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            width: 90%;
            font-size: 16px;
        }

        button {
            background: #ff4081;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #e91e63;
        }

        img {
            margin-top: 10px;
            max-width: 100%;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <h1>Image Compressor</h1>
    <div class="container">
        <form action="compress.php" method="post" enctype="multipart/form-data">
            <label>Select Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required onchange="previewImage(event)">
            
            <br><img id="preview" style="display: none; max-height: 200px;"><br>

            <label>Quality (1-100):</label>
            <input type="number" name="quality" id="quality" min="1" max="100" value="75" required>

            <label>New Width (Optional):</label>
            <input type="number" name="width" id="width" placeholder="Auto">

            <label>New Height (Optional):</label>
            <input type="number" name="height" id="height" placeholder="Auto">

            <button type="submit">Compress Image</button>
        </form>
    </div>

    <p class="footer">Made by Mohsin Khan</p>

    <script>
        function previewImage(event) {
            let reader = new FileReader();
            reader.onload = function() {
                let output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

</body>
</html>
