<!DOCTYPE html>
<html>
<head>
    <title>New Post Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        .post-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin-top: 20px;
        }
        .post-details strong {
            display: block;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h3>Hello,</h3>
        <p>We are excited to inform you that a new post titled <strong>"{{ $data['post'] }}"</strong> has just been published on our platform. Don’t miss out on this fresh content, created to inspire and engage!</p>

        <div class="post-details">
            <strong>Post Details:</strong>
            <p><strong>Title:</strong> {{ $data['post'] }}</p>
            <p><strong>Published By:</strong> {{ $data['author'] }}</p>
            <p><strong>Published On:</strong> {{ $data['publish_date'] }}</p>
        </div>

        <p class="footer">Best Regards,<br>Tushar Gehlot</p>
    </div>
</body>
</html>
