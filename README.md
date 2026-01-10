# Simple MVC Example - Book Management

This is a simple PHP MVC (Model-View-Controller) example project to help students understand the MVC architectural pattern. The project demonstrates basic CRUD operations (Create, Read, Update, Delete) for managing books.

## What is MVC?

MVC is a software design pattern that separates an application into three interconnected components:

- **Model**: Handles data and business logic (interacts with database)
- **View**: Handles presentation logic (displays data to users)
- **Controller**: Handles user input and coordinates between Model and View

## Project Structure

```
library_mvc_project/
├── app/
│   ├── controllers/
│   │   └── BookController.php     ← Handles book-related requests
│   ├── models/
│   │   └── Book.php                ← Handles database operations
│   ├── views/
│   │   ├── books/
│   │   │   ├── index.php           ← List all books
│   │   │   ├── show.php            ← Show single book
│   │   │   ├── create.php          ← Create book form
│   │   │   └── edit.php            ← Edit book form
│   │   └── layouts/
│   │       ├── header.php          ← Header template
│   │       └── footer.php          ← Footer template
│   └── core/
│       ├── Database.php            ← Database connection
│       ├── Controller.php          ← Base controller class
│       └── Router.php              ← URL routing
├── config/
│   └── config.php                  ← Configuration settings
├── database/
│   └── schema.sql                  ← Database schema
└── public/
    ├── index.php                   ← Entry point
    ├── .htaccess                   ← URL rewriting
    ├── css/
    │   └── style.css               ← Styles
    └── js/
        └── script.js               ← JavaScript
```

## Setup Instructions

### 1. Requirements

- **XAMPP** or **WAMP** (includes Apache, PHP, MySQL)
- Web browser (Chrome, Firefox, etc.)
- Text editor (VS Code, Sublime Text, etc.)

### 2. Installation Steps

1. **Extract the project folder** to your web server directory:
   - For XAMPP: `C:\xampp\htdocs\`
   - For WAMP: `C:\wamp64\www\`

2. **Start Apache and MySQL** from XAMPP/WAMP control panel

3. **Create the database**:
   - Open phpMyAdmin (<http://localhost/phpmyadmin>)
   - Click "Import" tab
   - Choose `database/schema.sql` file
   - Click "Go" to import

4. **Configure database connection**:
   - Open `config/config.php`
   - Update these lines if needed:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');           // Your MySQL password
   define('DB_NAME', 'library_db');
   ```

5. **Configure URL**:
   - Open `config/config.php`
   - Update the URL_ROOT to match your project location:

   ```php
   define('URL_ROOT', '/library_mvc_project/public');
   ```

6. **Update .htaccess**:
   - Open `public/.htaccess`
   - Update the RewriteBase to match your project:

   ```apache
   RewriteBase /library_mvc_project/public
   ```

### 3. Access the Application

Open your browser and go to:

```
http://localhost/library_mvc_project/public/book
```

## How It Works

### Request-Response Flow Diagram

```
                              ┌─────────────┐
                              │    USER     │
                              │   BROWSER   │
                              └──────┬──────┘
                                     │ HTTP Request
                                     │ /book/show/1
                                     ▼
                    ┌────────────────────────────────┐
                    │   public/.htaccess             │
                    │   Rewrites to index.php        │
                    └────────────┬───────────────────┘
                                 │
                                 ▼
                    ┌────────────────────────────────┐
                    │   public/index.php             │
                    │   (Front Controller)           │
                    │   - Loads config               │
                    │   - Initializes Router         │
                    └────────────┬───────────────────┘
                                 │
                                 ▼
                    ┌────────────────────────────────┐
                    │   app/core/Router.php          │
                    │   Parses URL:                  │
                    │   controller → BookController  │
                    │   method → show                │
                    │   params → [1]                 │
                    └────────────┬───────────────────┘
                                 │
                                 ▼
        ┌────────────────────────────────────────────────────┐
        │          app/controllers/BookController.php        │
        │          (CONTROLLER - Handles Logic)              │
        │          - Receives request                        │
        │          - Validates input                         │
        │          - Coordinates Model & View                │
        └────────┬──────────────────────────────┬────────────┘
                 │                              │
                 │ Need data?                   │ Need display?
                 ▼                              ▼
    ┌────────────────────────┐      ┌─────────────────────────┐
    │   app/models/Book.php  │      │   app/views/books/      │
    │   (MODEL - Data)       │      │   (VIEW - Presentation) │
    │   - getAllBooks()      │      │   - index.php           │
    │   - getBookById()      │      │   - show.php            │
    │   - createBook()       │      │   - create.php          │
    │   - updateBook()       │      │   - edit.php            │
    │   - deleteBook()       │      │   - layouts/header.php  │
    └───────┬────────────────┘      │   - layouts/footer.php  │
            │                       └─────────────────────────┘
            │ Uses PDO                          │
            ▼                                   │
    ┌──────────────────┐                        │
    │ app/core/        │                        │
    │ Database.php     │                        │
    │ (Connection)     │                        │
    └────┬─────────────┘                        │
         │                                      │
         ▼                                      │
    ┌──────────────────┐                        │
    │  MySQL Database  │                        │
    │  Table: books    │                        │
    └────┬─────────────┘                        │
         │ Returns data                         │
         └──────────┬───────────────────────────┘
                    │
                    ▼
            ┌───────────────┐
            │  View renders │
            │  HTML output  │
            └───────┬───────┘
                    │
                    ▼
              ┌──────────┐
              │   USER   │
              │  BROWSER │
              └──────────┘
```

### File and Folder Responsibilities Summary

| Component | Location | Responsibility |
|-----------|----------|----------------|
| **.htaccess** | `public/` | URL rewriting, redirect all requests to index.php |
| **index.php** | `public/` | Front controller, application entry point |
| **config.php** | `config/` | Application configuration, database credentials |
| **Router.php** | `app/core/` | Parse URLs and route to appropriate controllers |
| **Controller.php** | `app/core/` | Base controller class with view/model loading methods |
| **Database.php** | `app/core/` | Database connection singleton, provides PDO instance |
| **BookController.php** | `app/controllers/` | Handle book-related requests, coordinate Model & View |
| **Book.php** | `app/models/` | Database operations for books table (CRUD) |
| **index.php** | `app/views/books/` | Display list of all books |
| **show.php** | `app/views/books/` | Display single book details |
| **create.php** | `app/views/books/` | Display form to add new book |
| **edit.php** | `app/views/books/` | Display form to edit existing book |
| **header.php** | `app/views/layouts/` | Common header, navigation, CSS links |
| **footer.php** | `app/views/layouts/` | Common footer, closing tags, JavaScript links |
| **schema.sql** | `database/` | Database schema, table structure, sample data |
| **style.css** | `public/css/` | Application styles and visual design |
| **script.js** | `public/js/` | Client-side JavaScript functionality |

### MVC Flow Example

When you visit `http://localhost/library_mvc_project/public/book`:

1. **Request enters** through `public/index.php` (Front Controller)

2. **Router** (`app/core/Router.php`) parses the URL:
   - URL: `/book` → Controller: `BookController`, Method: `index()`

3. **Controller** (`app/controllers/BookController.php`):

   ```php
   public function index() {
       $bookModel = $this->model('Book');      // Load Model
       $books = $bookModel->getAllBooks();     // Get data
       $data = ['title' => 'All Books', 'books' => $books];
       $this->view('books/index', $data);      // Load View
   }
   ```

4. **Model** (`app/models/Book.php`) fetches data from database:

   ```php
   public function getAllBooks() {
       $query = "SELECT * FROM books ORDER BY title ASC";
       // ... executes query and returns data
   }
   ```

5. **View** (`app/views/books/index.php`) displays the data:

   ```php
   <?php foreach ($books as $book): ?>
       <td><?= $book['title'] ?></td>
   <?php endforeach; ?>
   ```

### URL Routing Examples

| URL | Controller | Method | Description |
|-----|------------|--------|-------------|
| `/book` | BookController | index() | List all books |
| `/book/show/1` | BookController | show(1) | Show book with ID 1 |
| `/book/create` | BookController | create() | Show create form |
| `/book/store` | BookController | store() | Process create form |
| `/book/edit/1` | BookController | edit(1) | Show edit form |
| `/book/update/1` | BookController | update(1) | Process edit form |
| `/book/delete/1` | BookController | delete(1) | Delete book |

## Key Features Demonstrated

### 1. **Separation of Concerns**

- Database logic is in the Model
- Display logic is in the View
- Request handling is in the Controller

### 2. **CRUD Operations**

- **Create**: Add new books
- **Read**: View all books or single book
- **Update**: Edit existing books
- **Delete**: Remove books

### 3. **Security Features**

- **Prepared Statements**: Prevents SQL injection
- **Input Validation**: Server-side validation
- **XSS Protection**: Using `htmlspecialchars()`

### 4. **Database Design**

- Proper table structure
- Auto-increment primary key
- Indexes for better performance
- Timestamps for tracking

## Code Examples

### Creating a New Book (Controller)

```php
// app/controllers/BookController.php
public function store() {
    // Validate input
    if (empty($_POST['title'])) {
        $_SESSION['errors'][] = 'Title is required.';
        $this->redirect('/book/create');
        return;
    }

    // Prepare data
    $data = [
        'title' => trim($_POST['title']),
        'author' => trim($_POST['author']),
        // ... more fields
    ];

    // Call model to save
    $bookModel = $this->model('Book');
    $bookId = $bookModel->createBook($data);

    if ($bookId) {
        $_SESSION['success'] = 'Book added successfully!';
        $this->redirect('/book/show/' . $bookId);
    }
}
```

### Database Query (Model)

```php
// app/models/Book.php
public function createBook($data) {
    $query = "INSERT INTO books (title, author, isbn)
              VALUES (:title, :author, :isbn)";

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':author', $data['author']);
    $stmt->bindParam(':isbn', $data['isbn']);

    if ($stmt->execute()) {
        return $this->db->lastInsertId();
    }
    return false;
}
```

## Common Issues & Solutions

### Issue 1: 404 Error / Page Not Found

**Solution**: Check `.htaccess` RewriteBase matches your project folder

### Issue 2: Database Connection Error

**Solution**: Verify database credentials in `config/config.php`

### Issue 3: Can't add/edit books

**Solution**: Ensure the books table exists (run schema.sql)

### Issue 4: Styles not loading

**Solution**: Check URL_ROOT in `config/config.php`

## Learning Exercises

Try these to practice:

1. **Add a search feature** to filter books by title or author
2. **Add pagination** to display 10 books per page
3. **Add a category filter** dropdown
4. **Create another entity** (e.g., Authors) with its own MVC files
5. **Add image upload** for book covers

## Project Extension Ideas

Students can extend this project for their final project:

- Add user authentication (login/register)
- Add book borrowing system (loans)
- Add member management
- Add reporting features
- Add book availability tracking
- Add email notifications
- Add search with filters

## Important Notes for Students

✅ **DO:**

- Follow the MVC pattern strictly
- Use prepared statements for all SQL queries
- Validate all user inputs
- Use meaningful variable and function names
- Comment your code

❌ **DON'T:**

- Put SQL queries in Controllers or Views
- Mix business logic in Views
- Trust user input without validation
- Store sensitive data in plain text
- Forget to use htmlspecialchars() for output

## Resources

- [PHP Official Documentation](https://www.php.net/manual/en/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [W3Schools PHP Tutorial](https://www.w3schools.com/php/)
- [MVC Pattern Explanation](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)

## Need Help?

If you encounter issues:

1. Check error logs in XAMPP/WAMP
2. Enable error reporting in `config/config.php`
3. Use `var_dump()` or `print_r()` for debugging
4. Ask your instructor during lab sessions

---

**Good luck with your learning! 🚀**
