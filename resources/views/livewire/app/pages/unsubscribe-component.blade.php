<div>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Email Template</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
        <style>
            body,
            html {
                font-family: "Inter", sans-serif;
                overflow-x: hidden;
            }

            *,
            body {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>

    <body>
        <div
            style="
        max-width: 640px;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
      ">
            <table style="width: 100%; border-collapse: collapse; margin-top: 300px; margin-bottom: 300px;">
                <!-- Verify Section  -->
                <tr>
                    <td
                        style="
              background-image: url('{{ asset('assets/app/images/email/email_shape.png') }}');
              background-position: center center;
              background-size: cover;
              padding: 48px 30px 71px 30px;
            ">
                        <table style="width: 100%; border-collapse: collapse">
                            <tr>
                                <td>
                                    <table style="width: 100%; border-collapse: collapse">
                                        <tr>
                                            <td style="text-align: center">
                                                <img src="{{ asset('assets/app/icons/like.png') }}" alt="logo"
                                                    style="max-width: 47px; max-height: 41px" />
                                                <h4
                                                    style="
                            color: #365208;
                            font-size: 32px;
                            font-style: normal;
                            font-weight: 700;
                            line-height: normal;
                            margin-top: 16px;
                          ">
                                                    You have been successfully unsubscribed!
                                                </h4>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>

    </html>
</div>
