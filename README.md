# Blogging Web Application

## Project Description

This project is a dynamic web blogging application that allows users to create, manage, and search for posts. It includes functionalities for registration/login, posting, editing, and deleting posts, as well as a user management system.

## Key Features

### ✅ Home Page (`index.php`)

- Displays three random posts from the database.
- If the user is logged in, a button for accessing the dashboard is shown.
- If not logged in, users are prompted to log in to see more posts.

### ✅ Dashboard (`dashboard.php`)

- List of all posts made by all users.
- Search posts by title, content, or author.
- If the user is the author of a post, options for editing and deleting the post are shown.
- A form to create a new post.

### ✅ User Management

- Login/Register for access to the dashboard.
- Each user has their own profile and can view their posts.

### ✅ Post Management

- Registered users can create, edit, and delete their posts.
- Posts are linked to the user who created them.

### ✅ Post View Page

- Each post has its own dedicated page (`viewPost.php`).
- Ability to add links to the author's profile.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP (with PDO for secure SQL queries)
- **Database**: MySQL (running locally with XAMPP)

## Installation

1. Clone the repository.
2. Set up the MySQL database locally using XAMPP.
3. Configure database credentials in the project.
4. Open `index.php` in your browser to start using the app.



