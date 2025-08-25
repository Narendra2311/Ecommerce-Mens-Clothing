# Mallt (E‑commerce PHP Project)

An e‑commerce web application built with PHP. This repository contains the application source code, role‑based login pages, and static assets.

## Quick Look
- Entry point: `index.php`
- Database config: `db.php`
- Role-based modules: `adminn/`, `manager/`, `deliveryboy/`, `homepage/`
- Assets: `css/`, `image/`, `gif/`, `uploads/`
- PHP dependencies (Composer): `composer.json` and `vendor/` (see `.gitignore`)

## Project Tree (excerpt)
```text
mallt/
├── adminn/
│   ├── css/
│   │   ├── maps/
│   │   └── style.css
│   ├── fonts/
│   │   ├── Ubuntu/
│   │   └── .DS_Store
│   ├── images/
│   │   ├── dashboard/
│   │   ├── faces/
│   │   ├── faces-clipart/
│   │   ├── profilephoto/
│   │   ├── verifydoc/
│   │   ├── .DS_Store
│   │   ├── favicon.png
│   │   ├── logo-mini.svg
│   │   ├── logo.jpg
│   │   └── logo.svg
│   ├── js/
│   │   ├── .DS_Store
│   │   ├── chart.js
│   │   ├── dashboard.js
│   │   ├── file-upload.js
│   │   ├── misc.js
│   │   └── off-canvas.js
│   ├── pages/
│   │   ├── charts/
│   │   ├── forms/
│   │   ├── icons/
│   │   ├── samples/
│   │   ├── tables/
│   │   └── ui-features/
│   ├── partials/
│   │   ├── _footer.html
│   │   ├── _navbar.html
│   │   └── _sidebar.html
│   ├── PSD/
│   │   └── Purple_dashboard_free.psd
│   ├── scss/
│   │   ├── components/
│   │   ├── landing-screens/
│   │   ├── mixins/
│   │   ├── .DS_Store
│   │   ├── _background.scss
│   │   ├── _demo.scss
│   │   ├── _fonts.scss
│   │   ├── _footer.scss
│   │   ├── _functions.scss
│   │   ├── _misc.scss
│   │   ├── _navbar.scss
│   │   ├── _reset.scss
│   │   ├── _sidebar.scss
│   │   ├── _typography.scss
│   │   ├── _utilities.scss
│   │   ├── _variables.scss
│   │   └── style.scss
│   ├── uploads/
│   │   └── denimjacket.jpg
│   ├── vendors/
│   │   ├── css/
│   │   ├── iconfonts/
│   │   ├── js/
│   │   └── autoload.php
│   ├── .gitignore
│   ├── addemployee.php
│   ├── admindashboard.php
│   ├── CHANGELOG.md
│   ├── customer.php
│   ├── deliveryboy.php
│   ├── gulpfile.js
│   ├── header.php
│   ├── orderreport.php
│   ├── package-lock.json
│   ├── package.json
│   ├── productmanager.css
│   ├── productmanager.php
│   ├── productreport.php
│   ├── README.md
│   ├── signout.php
│   ├── viewcategory.php
│   └── viewproducts.php
├── css/
│   └── rolebasedlogin.css
├── deliveryboy/
│   ├── Deliveryboy.css
│   └── logo.jpg
├── gif/
│   └── Pendulum.gif
├── homepage/
│   ├── css/
│   │   ├── category.css
│   │   ├── footer.css
│   │   ├── header.css
│   │   ├── joggers.css
│   │   ├── product.css
│   │   ├── product2.css
│   │   └── style.css
│   ├── img/
│   │   ├── 3d.jpg
│   │   ├── background.jpg
│   │   ├── blackshirt.jpg
│   │   ├── brand1.png
│   │   ├── brand2.png
│   │   ├── brand3.png
│   │   ├── brand4.png
│   │   ├── brand5.png
│   │   ├── brand6.png
│   │   ├── fea1.jpg
│   │   ├── fea2.jpg
│   │   ├── fea3.jpg
│   │   ├── fea4.jpg
│   │   ├── fea5.jpg
│   │   ├── fea6.jpg
│   │   ├── ffffc.png
│   │   ├── h.jpeg
│   │   ├── i.jpeg
│   │   ├── images.jpeg
│   │   ├── jacket.jpg
│   │   ├── jacket.png
│   │   ├── s-l400.jpg
│   │   ├── s1.jpeg
│   │   ├── tren1.jpg
│   │   ├── tren2.jpg
│   │   ├── tren3.jpg
│   │   └── tren4.jpg
│   ├── js/
│   │   └── script.js
│   ├── sliderimg/
│   │   ├── img1.jpg
│   │   ├── img2.jpg
│   │   └── img3.jpg
│   ├── add_to_cart.php
│   ├── addresselection.php
│   ├── category.php
│   ├── footer.php
│   ├── get_cart_count.php
│   ├── glider.min.css
│   ├── glider.min.js
│   ├── header.php
│   ├── homepage.php
│   ├── insert_cart.php
│   ├── Logout.php
│   ├── myaccount.php
│   ├── myorders.php
│   ├── order_confirmation.php
│   ├── payment.php
│   ├── personalinfo.php
│   ├── productdescription.php
│   ├── products.php
│   ├── remove_product.php
│   └── Search.php
├── image/
│   ├── adminprofile.jpeg
│   ├── boxer.jpeg
│   ├── cargo.jpeg
│   ├── dark vanilla.jpg
│   ├── dashboard.png
│   ├── download (1).jpeg
│   ├── download.jpeg
│   ├── Emptypage.png
│   ├── full-length-portrait-confident-young-african-man.jpg
│   ├── images.png
│   ├── img1.jpg
│   ├── img2.jpg
│   ├── img3.jpg
│   ├── jacket.jpg
│   ├── kargo.jpeg
│   ├── olive green.jpg
│   ├── shirt.jpeg
│   ├── thshirt3.jpg
│   ├── thsirt1.jpg
│   ├── thsirt2.jpg
│   ├── trouser1.jpg
│   ├── trouser2.jpg
│   ├── trouser3.jpg
│   ├── trouser4.jpg
│   ├── trouser5.jpg
│   ├── trouser6.jpg
│   ├── tshirt4.jpg
│   ├── tshirt5.jpg
│   ├── tshirt6.jpg
│   ├── wallet.webp
│   └── white.jpg
├── manager/
│   ├── css/
│   │   ├── maps/
│   │   └── style.css
│   ├── fonts/
│   │   ├── Ubuntu/
│   │   └── .DS_Store
│   ├── images/
│   │   ├── dashboard/
│   │   ├── faces/
│   │   ├── faces-clipart/
│   │   ├── .DS_Store
│   │   ├── favicon.png
│   │   ├── logo-mini.svg
│   │   ├── logo.jpg
│   │   └── logo.svg
│   ├── js/
│   │   ├── .DS_Store
│   │   ├── chart.js
│   │   ├── dashboard.js
│   │   ├── file-upload.js
│   │   ├── misc.js
│   │   └── off-canvas.js
│   ├── pages/
│   │   ├── charts/
│   │   ├── forms/
│   │   ├── icons/
│   │   ├── samples/
│   │   ├── tables/
│   │   └── ui-features/
│   ├── partials/
│   │   ├── _footer.html
│   │   ├── _navbar.html
│   │   └── _sidebar.html
│   ├── PSD/
│   │   └── Purple_dashboard_free.psd
│   ├── scss/
│   │   ├── components/
│   │   ├── landing-screens/
│   │   ├── mixins/
│   │   ├── .DS_Store
│   │   ├── _background.scss
│   │   ├── _demo.scss
│   │   ├── _fonts.scss
│   │   ├── _footer.scss
│   │   ├── _functions.scss
│   │   ├── _misc.scss
│   │   ├── _navbar.scss
│   │   ├── _reset.scss
│   │   ├── _sidebar.scss
│   │   ├── _typography.scss
│   │   ├── _utilities.scss
│   │   ├── _variables.scss
│   │   └── style.scss
│   ├── uploads/
│   │   └── denimjacket.jpg
│   ├── vendors/
│   │   ├── css/
│   │   ├── iconfonts/
│   │   └── js/
│   ├── .DS_Store
│   ├── .gitignore
│   ├── category.php
│   ├── CHANGELOG.md
│   ├── customer.php
│   ├── dashboard.php
│   ├── deletecategory.php
│   ├── deleteproducts.php
│   ├── deliveryboy.php
│   ├── editcat.php
│   ├── editproducts.php
│   ├── gulpfile.js
│   ├── inventory.php
│   ├── orderreport.php
│   ├── package-lock.json
│   ├── package.json
│   ├── productmanager.css
│   ├── productreport.php
│   ├── products.php
│   ├── README.md
│   ├── signout.php
│   ├── update_quantity.php
│   ├── viewcategory.php
│   └── viewproducts.php
├── nbproject/
│   ├── private/
│   │   ├── config.properties
│   │   ├── private.properties
│   │   └── private.xml
│   ├── project.properties
│   └── project.xml
├── uploads/
│   ├── background.jpg
│   ├── boss.png
│   ├── delivery-boy.png
│   ├── jacket.jpg
│   └── manager.png
├── vendor/
│   └── phpmailer/
├── adminlogin.php
├── adminthankyou.php
├── animation.html
├── composer.json
├── composer.lock
├── customerlogin.php
├── customerthankyou.php
├── db.php
├── deliveryboylogin.php
├── deliverythankyou.php
├── index.php
├── login.css
├── login.js
├── productmanagerlogin.php
├── productmanagerthankyou.php
└── Rolebasedlogin.php
```

## Getting Started (Local)
1. **Requirements**
   - PHP 8.x (or 7.4+) with common extensions
   - Composer
   - MySQL/MariaDB
   - A local server (XAMPP/WAMP/Laragon) or PHP's built‑in server

2. **Setup**
   - Clone or download this repository
   - Create a database and import any SQL schema (if provided)
   - Update database credentials in `db.php`

3. **Install PHP dependencies**
```bash
composer install
```

4. **Run locally**
- Using XAMPP/WAMP: place the project in the web root (e.g., `htdocs/`) and visit `http://localhost/mallt`.
- Or use PHP's built‑in server from the project folder:
```bash
php -S localhost:8000
```

## Notes
- Environment files and Composer `vendor/` are ignored in version control.
- For production, secure credentials and review file/folder permissions.

## License
Add your license details here (MIT, Apache‑2.0, etc.).

## Credits
Developed by Narendra.