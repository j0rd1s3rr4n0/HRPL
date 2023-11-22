# HRPL - High-precision Real-time People Locator
![HRPL LOGO](/img/logo.png)

GeoSpy is a high-precision, real-time people locator tool that operates through a generated link. It is developed for educational purposes to demonstrate the potential risks associated with location-sharing technologies. This project is not intended for malicious use, and the creator does not assume any responsibility for its misuse.

## Disclaimer

**Note: This project is for educational purposes only. The creator does not endorse or encourage any unauthorized use of location information or any activities that violate privacy laws. The misuse of this tool for tracking individuals without their consent is strictly prohibited.**

## Overview

GeoSpy provides a glimpse into the potential vulnerabilities associated with location-sharing on the internet. It is essential to use this tool responsibly and ethically, respecting the privacy and consent of individuals.

## Features

- High-precision location tracking
- Real-time updates via generated links
- Educational tool for understanding privacy risks

## Getting Started with GeoSpy

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/j0rd1s3rr4n0/HRPL
    ```

2. **Prerequisites:**
    - Web server (XAMPP, WAMP, Apache 2.4, Nginx)
    - Database system (MySQL, MariaDB, SQLite3, PostgreSQL)
    - PHP (recommended version 8.0 or higher)

3. **Configure Environment Variables:**

    - Clone `.env.example` and rename it to `.env`.
    - Update the values inside `.env` with your specific configuration, removing any comments marked with `#`.

4. **Move Files to Web Server Public Folder:**

    Move all files from the cloned repository to the public folder of your web server.

5. **Secure the Environment Variables:**

    Create an `.htaccess` file to secure the `.env` file and prevent unauthorized access.

6. **Run the Web Server:**

    Start your web server to host the GeoSpy application.

7. **Access Setup Script:**

    Visit the following URL to run the setup script for the database:
    
    `https://yourservername/setup_db.php` or [https://localhost/setup_db.php](https://localhost/setup_db.php)

8. **Configure Database:**

    Follow the instructions on the setup script to configure the database connection. GeoSpy supports MySQL, MariaDB, SQLite3, and PostgreSQL.

9. **Access GeoSpy Login:**

    Navigate to the login page at:
        `https://yourservername/login.php` or [https://localhost/login.php](https://localhost/login.php)

    **Default Login Credentials:**
    - **Username:** `ROOT`
    - **Password:** `TOOR`

10. **Share GeoSpy:**

    Share the link to your GeoSpy application with others:
    `https://yourservername` or [https://localhost](https://localhost)

**Note: Ensure that you have the legal right to track the location of individuals and comply with relevant privacy laws and regulations. Misuse of this tool may result in legal consequences.**


## Legal Considerations

- This project is meant for educational purposes only.
- Respect privacy laws and obtain consent before using location-tracking tools.
- The creator is not responsible for any misuse or illegal activities conducted with this tool.

## Contribution

Contributions to the GeoSpy project are welcome. However, contributors must adhere to ethical guidelines and prioritize user privacy.

## Support

For any questions or concerns regarding GeoSpy, please contact the project maintainer.

## License

This project is licensed under the [MIT License](LICENSE). See the LICENSE file for details.

**Use this tool responsibly, ethically, and in compliance with the law.**
