<!DOCTYPE html>
<html>
<head>
    <style>
        html, body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            line-height: 1.4;
            max-width: 768px;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        h1 {
            font-size: 1.5rem;
            font-weight: normal;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

{if isset($title)}
    <h1>{$title}</h1>
    <hr>
{/if}

<p>{$message}</p>

</body>
</html>