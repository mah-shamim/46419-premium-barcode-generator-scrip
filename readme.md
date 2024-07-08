Overview
===========
Empower your business with our state-of-the-art Barcode Generator PHP script, a versatile solution designed to streamline your inventory management, product tracking, and transaction processes. Our script provides an easy-to-use interface for generating dynamic barcodes on-the-fly, allowing you to effortlessly integrate barcode functionality into your web applications.


Features
============
**Key Features:**

Dynamic Barcode Generation: Generate barcodes dynamically based on your specific requirements, supporting various barcode types such as Code 128, QR Code, UPC-A, and more.

**Customization Options:** 

Tailor barcode appearance to suit your branding and design preferences. Customize colors, sizes, and text to create a professional and cohesive look for your products.

**User-Friendly Interface:** 

Our intuitive interface makes it easy for both developers and end-users to generate barcodes with minimal effort. Generate single or batch barcodes efficiently, saving you time and resources.

**Versatile Integration:** 

Seamlessly integrate the script into your existing PHP applications or web projects. Whether you're managing an e-commerce platform, inventory system, or ticketing service, our script adapts to your needs.

**Scalability and Performance:** 

Built with scalability in mind, our Barcode Generator PHP script ensures optimal performance, even as your business grows. Generate barcodes for a single item or thousands, effortlessly accommodating your scaling requirements.

**Secure and Reliable:** 

Trust in the security and reliability of our script. Protect sensitive data and ensure accurate barcode generation for enhanced business operations.


**Requirements:**
- PHP 5.6.0 or above
- PDO and MySQLI extension
- PHP CURL
- GD extension
- Rewrite module
- Multibyte String (Mbstring)
- WHOIS Port - TCP 43 must be allowed
- "allow_url_fopen" must be allowed
- Safe Mode must be Off
- Greater execution time must be recommended
- SMTP Mail Server (optional)

**Installation**
1. Upload the files present on "Upload" directory to your website using FTP or file manager in your hosting's control panel & keep writable mode for "uploads" directory and "/core/config/db.config.php" file
2. Create MySQL database in your hosting account.
3. Visit the "index.php" page in your web browser where you have upload the files e.g. http://www.example.com/index.php
4. It automatically redirect to installation panel page.
5. Provide the necessary information i.e. database-host, database-name, database-username and database-password
6. Now click "Install" button, after few seconds (mostly 5 to 10 seconds) it will be shown a successful message with database table creation log file.
7. You have done the installation. If you found any errors and bugs while installation - Please report and check the support section.
8. After installation, put your site on maintenance mode (Admin Panel -> Maintenance) and make basic changes such as title, description, keywords etc..
9. After done all customization, release the maintenance mode.


**Setup CronJob**
1. Setting up cron is an important step in the installation. It helps to generate sitemap, database backups and clean up temporary directory regularly.
2. Cron Job path can be found on Admin Panel -> Cron Job -> Cron Job Path
3. Interval between cron job executions is 5 minutes to 15 minutes (Recommended).
4. How to setup a cron job in cpanel?
    - Tutorial 1: https://www.namecheap.com/support/knowledgebase/article.aspx/9453/29/how-to-runscripts-via-cron-jobs
    - Tutorial 2: http://support.hostgator.in/articles/cpanel/how-do-i-create-and-delete-a-cron-job
    - Tutorial 3: https://www.siteground.com/tutorials/cpanel/cron_jobs.htm

Cron Job setup steps vary on each hosting service and control panels. So, it is recommended to refer hosting service knowledge base / help sections

**Translate to your Language**
1. Login into Admin Panel -> Interface -> Create New Language
2. Keep the status disabled until making complete translation.
3. After making translation, enable the language from admin panel.

**Theme Customization**
1. Don't do any customization on "default" theme. It will make you difficult to upgrade on future releases of Turbo Website Reviewer.
2. So, always clone the "default" theme directory and make it as a new theme (Admin Panel -> Interface -> Manage Themes -> Select Theme -> Click "Clone" button). Using the cloned files, do any customization of interface.
3. Themes files are combination of HTML and simple PHP codes. 90% of codes are Pure HTML on theme files.
4. So make use of any HTML editors and do any customizations.
5. Theme information must be included on "themeDetails.xml" file. If you cloned exiting theme, make sure you change this information first.


Your admin login link is (www.yourwebsite.com/admin)