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
        <table style="width: 100%; border-collapse: collapse">
            <!-- Header Section  -->
            <tr>
                <td style="padding-top: 24px; padding-bottom: 24px; text-align: center">
                    <a href="https://www.voreapp.co/">
                        <img src="{{ asset('assets/app/images/header/email_logo.png') }}" alt="email logo"
                            style="max-width: 200px; max-height: 60px" />
                    </a>
                </td>
            </tr>
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
                                                Thank you for signing up!
                                            </h4>
                                            <h3
                                                style="
                            color: #fff;
                            font-size: 42px;
                            font-style: normal;
                            font-weight: 600;
                            line-height: 120%;
                            margin-top: 17px;
                          ">
                                                Verify your email address
                                            </h3>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Message Section  -->
            <tr>
                <td style="padding: 64px 30px">
                    <table style="width: 100%; border-collapse: collapse">
                        <tr>
                            <td>
                                <table style="width: 100%; border-collapse: collapse">
                                    <tr>
                                        <td>
                                            <h3
                                                style="
                            color: #000;
                            font-size: 18px;
                            font-style: normal;
                            font-weight: 500;
                            line-height: normal;
                          ">
                                                Hey {{ $name }},
                                            </h3>
                                            <p
                                                style="
                            color: #000;
                            font-size: 18px;
                            font-style: normal;
                            font-weight: 500;
                            line-height: normal;
                            margin-top: 20px;
                          ">
                                                Thank you for joining Vore! To activate your account and start your
                                                journey to a healthier lifestyle, please click the verification button
                                                below
                                            </p>
                                            <div style="text-align: center; margin-top: 64px">
                                                <a href="{{ url('/') }}/email-verification?token={{ $token }}"
                                                    style="
                              color: #fff;
                              text-align: center;
                              font-size: 18px;
                              font-style: normal;
                              font-weight: 500;
                              line-height: normal;
                              border-radius: 126px;
                              text-decoration: none;
                              padding: 16px 40px;
                              background: #8eb056;
                            ">Verify
                                                    My Account</a>
                                            </div>
                                            <h4
                                                style="
                            color: #000;
                            font-size: 18px;
                            font-style: normal;
                            font-weight: 500;
                            line-height: normal;
                            margin-top: 64px;
                          ">
                                                Best Regards,
                                            </h4>
                                            <h5
                                                style="
                            color: #000;
                            font-size: 18px;
                            font-style: normal;
                            font-weight: 500;
                            line-height: normal;
                            margin-top: 10px;
                          ">
                                                The Vore Team
                                            </h5>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Footer Section  -->
            <tr>
                <td style="background: #f9fbf7; padding: 20px 30px 30px 30px">
                    <table style="width: 100%; border-collapse: collapse">
                        <tr>
                            <td style="border-bottom: 1px solid #e0e0e0; padding-bottom: 10px">
                                <table
                                    style="
                      display: inline-block;
                      max-width: 300px;
                      width: 100%;
                      border-collapse: collapse;
                      padding-top: 20px;
                      vertical-align: top;
                    ">
                                    <tr>
                                        <td style="text-align: start">
                                            <a href="https://www.voreapp.co/" target="_blank">
                                                <img src="{{ asset('assets/app/images/header/email_logo.png') }}"
                                                    alt="logo" style="max-width: 104px; max-height: 44px" />
                                            </a>
                                            <div style="margin-top: 30px">
                                                <a href="https://www.instagram.com/vore.app/" target="_blank"
                                                    style="
                              text-decoration: none;
                              padding-right: 16px;
                              border-right: 1px solid #dbdee4;
                              margin-top: 6px;
                              display: inline-block;
                            ">
                                                    <img src="{{ asset('assets/app/icons/instagram.png') }}"
                                                        alt="facebook" style="width: 24px; height: 24px" />
                                                </a>
                                                <a href="https://www.facebook.com/voreapp" target="_blank"
                                                    style="
                              text-decoration: none;
                              padding-right: 16px;
                              padding-left: 16px;
                              border-right: 1px solid #dbdee4;
                              margin-top: 6px;
                              display: inline-block;
                              margin-right: 16px;
                            ">
                                                    <img src="{{ asset('assets/app/icons/facebook.png') }}"
                                                        alt="facebook" style="width: 24px; height: 24px" />
                                                </a>
                                                <a href="https://www.linkedin.com/company/vore" target="_blank"
                                                    style="
                              text-decoration: none;
                              display: inline-block;
                              margin-top: 6px;
                            ">
                                                    <img src="{{ asset('assets/app/icons/linkdine.png') }}"
                                                        alt="facebook" style="width: 24px; height: 24px" />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table
                                    style="
                      display: inline-block;
                      max-width: 250px;
                      width: 100%;
                      border-collapse: collapse;
                      padding-top: 20px;
                      vertical-align: top;
                    ">
                                    <tr>
                                        <td style="text-align: start">
                                            <div>
                                                <h3
                                                    style="
                              color: #1f3462;
                              font-size: 18px;
                              font-style: normal;
                              font-weight: 500;
                              line-height: 19.491px;
                            ">
                                                    Download our app
                                                </h3>
                                                <div style="margin-top: 6px">
                                                    <a href="https://apps.apple.com/sa/app/vore/id6480172276"
                                                        target="_blank"
                                                        style="
                                text-decoration: none;
                                display: inline-block;
                                margin-top: 6px;
                                margin-right: 10px;
                              ">
                                                        <img src="{{ asset('assets/app/icons/app_store.png') }}"
                                                            alt="app store icon"
                                                            style="max-width: 125px; max-height: 32px" />
                                                    </a>
                                                    <a href="https://apps.apple.com/sa/app/vore/id6480172276"
                                                        target="_blank"
                                                        style="
                                text-decoration: none;
                                display: inline-block;
                                margin-top: 6px;
                              ">
                                                        <img src="{{ asset('assets/app/icons/google_play.png') }}"
                                                            alt="google icon"
                                                            style="max-width: 125px; max-height: 32px" />
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%; border-collapse: collapse">
                        <tr>
                            <td>
                                <p
                                    style="
                      color: #4c4c4c;
                      font-size: 14px;
                      font-style: normal;
                      font-weight: 400;
                      line-height: 17.325px;
                      margin-top: 16px;
                    ">
                                    If you have questions or need help, don't hesitate to
                                    contact our support team!
                                </p>
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%; border-collapse: collapse">
                        <tr>
                            <td>
                                <div style="margin-top: 19px">
                                    <a href="https://www.voreapp.co/terms-and-conditions"
                                        style="
                        color: #4c4c4c;
                        font-size: 14px;
                        font-style: normal;
                        font-weight: 700;
                        line-height: 17.325px;
                        text-decoration: none;
                        display: inline-block;
                        padding-right: 12px;
                        border-right: 1px solid #e0e0e0;
                      ">
                                        Terms & conditions
                                    </a>
                                    <a href="https://www.voreapp.co/terms-and-conditions"
                                        style="
                        color: #4c4c4c;
                        font-size: 14px;
                        font-style: normal;
                        font-weight: 700;
                        line-height: 17.325px;
                        text-decoration: none;
                        padding-right: 12px;
                        display: inline-block;
                        padding-left: 12px;
                        padding-right: 12px;
                        margin-right: 12px;
                        border-right: 1px solid #e0e0e0;
                      ">
                                        Privacy policy
                                    </a>
                                    <a href="https://www.voreapp.co/contact-us"
                                        style="
                        color: #4c4c4c;
                        font-size: 14px;
                        font-style: normal;
                        font-weight: 700;
                        line-height: 17.325px;
                        text-decoration: none;
                        display: inline-block;
                      ">
                                        Contact us
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%; border-collapse: collapse">
                        <tr>
                            <td>
                                <p
                                    style="
                      color: #4c4c4c;
                      font-size: 14px;
                      font-style: normal;
                      font-weight: 400;
                      line-height: 17.325px;
                      margin-top: 16px;
                    ">
                                    This message was sent to admin@voreapp.co. If you don't want
                                    to receive these emails from Nation Remit in the future, you
                                    can
                                    <a href="https://www.voreapp.co"
                                        style="
                        color: #4c4c4c;
                        font-weight: 700;
                        text-decoration: none;
                      ">edit
                                        your profile</a>
                                    or
                                    <a href="http://vore-app.test/unsubscribe" type="button"
                                        style="
                        color: rgb(26, 93, 209);
                        font-weight: 700;
                        text-decoration: underline;
                        padding: 0;
                        border: none;
                      ">
                                        unsubscribe</a>.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
