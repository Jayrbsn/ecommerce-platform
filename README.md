
# ITECA E-Commerce Platform

## 📌 Overview

This is a custom-built e-commerce platform enabling **buyers**, **sellers**, and **admins** to interact securely within a digital marketplace. It supports user registration, product management, dummy checkouts, and role-specific functionality for streamlined operations.

---

## 📚 Table of Contents

1. [Technologies Used](#technologies-used)
2. [Features](#features)
3. [Accessing the Website](#accessing-the-website)
4. [Admin Functionality](#admin-functionality)
5. [Product Management](#product-management)
6. [Shipping](#shipping)
7. [Orders](#orders)
8. [Updating Pages](#updating-pages)
9. [Payments](#payments)
10. [Web Traffic & Statistics](#web-traffic--statistics)
11. [Deployment Guide (AWS EC2)](#deployment-guide-aws-ec2)

---

## ⚙️ Technologies Used

- **Frontend**: HTML, CSS, Bootstrap 5, JavaScript (jQuery)
- **Backend**: PHP
- **Database**: MySQL
- **Hosting**: Amazon AWS EC2 (Linux instance)
- **No CMS**: All files are manually edited and deployed

---

## 🌟 Features

- Role-based access: Buyer, Seller, Admin
- Product browsing, adding to cart, and dummy checkout
- User and order management
- Admin dashboard with reporting tools
- Manual product CRUD functionality
- Clean, responsive UI (Bootstrap)

---

## 🔑 Accessing the Website

All users (buyers, sellers, admins) log in at the same URL. User permissions are stored in the database and dictate the functionality available post-login.

- **Platform URL**: `http://<your-ec2-public-ip>/ecommerce-platform/`
- **GitHub Repository**: _[Link to GitHub here]_

---

## 🛠️ Admin Functionality

Admins have access to a dedicated admin panel where they can:

- 🔧 Manage users (create, update, delete)
- 📦 Manage all listed products
- 📋 View and monitor all orders
- 📊 Generate role-specific reports

---

## 🛍️ Product Management

### Sellers

- Go to **Products** after login
- Click **Add Product** to upload an item
- Click **Delete** to remove a product you created

### Admins

- Use the **Admin Panel > Manage Products**
- Add, edit, or remove **any** product

### Updating a Product

1. Click **Edit** on the product
2. Update name, description, price, or stock
3. Click **Save**

---

## 🚚 Shipping

- **Currently**: No real shipping logic. Dummy checkout only.
- **Future Implementation Ideas**:
  - Integration with APIs like Courier Guy, DHL, Pargo
  - District-based delivery pricing (e.g., R60 local, R85 national)
  - Delivery options: Standard (3–5 days) or Next-Day
  - Sellers define delivery methods at listing time
  - Real-time delivery fees shown at checkout

---

## 📦 Orders

- Created when a buyer checks out
- Saved in `orders` and `order_items` tables
- Automatically marked as **Paid**
- **Admins**: View all orders
- **Buyers**: View own order history

---

## ✏️ Updating Pages

There is no CMS. To update content or pages:

1. Manually edit the `.php` files using a code editor
2. Upload via `scp` to your EC2 instance

---

## 💳 Payments

- Only **dummy payment** is implemented
- All orders are marked as **Paid** on checkout
- Future options: **PayFast**, **PayPal**, or similar payment APIs

---

## 📈 Web Traffic & Statistics

Not currently implemented.

### Future Suggestions:
- Add Google Analytics tracking script to PHP pages
- Build dashboard to view basic site stats

---

## ☁️ Deployment Guide (AWS EC2)

### Step 1: Create AWS Account

- [Create an AWS account](https://aws.amazon.com)

### Step 2: Launch EC2 Instance

- Use **Amazon Linux 2 AMI**
- Instance type: `t3.micro`
- Configure Security Group:
  - HTTP (Port 80) from `0.0.0.0/0`
  - SSH (Port 22) from **your IP**

### Step 3: Connect to EC2

```bash
chmod 400 ITECA_KEY_PAIR.pem
ssh -i ITECA_KEY_PAIR.pem ec2-user@<your-ec2-public-dns>
```

### Step 4: Install LAMP Stack

```bash
sudo yum update -y
sudo yum install -y httpd php php-mysqli mariadb105-server
sudo systemctl start httpd
sudo systemctl enable httpd
```

### Step 5: Upload Project Files

From your local machine:

```bash
scp -i ITECA_KEY_PAIR.pem -r ecommerce-platform ec2-user@<your-ec2-public-dns>:/home/ec2-user
```

### Step 6: Move Files to Web Directory

```bash
sudo mv /home/ec2-user/ecommerce-platform /var/www/html/
sudo chmod -R 755 /var/www/html/ecommerce-platform
```

### Step 7: Start MySQL Server

```bash
sudo systemctl start mariadb
sudo systemctl enable mariadb
```

### Step 8: Create Database

```bash
sudo mysql
CREATE DATABASE deliverable2;
USE deliverable2;
```

### Step 9: Import SQL Schema

```bash
mysql -u root deliverable2 < schema.sql
```

### Step 10: Verify Permissions

```bash
sudo chown -R apache:apache /var/www/html
sudo chmod -R 755 /var/www/html
```

### ✅ Done!

Visit your platform at:

```text
http://<your-ec2-public-ip>/ecommerce-platform/
```

---

## 📬 Contact

For any queries or support, please reach out to the project maintainer or file an issue on the [GitHub repository](#).
