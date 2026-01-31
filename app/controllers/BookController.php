<?php
require_once __DIR__ . '/../core/Controller.php';

class BookController extends Controller
{
    // ---------- USER METHODS ----------

    // action: user_books_index
    public function userIndex()
    {
        $this->requireAuth();

        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');

        // Get pagination and filter parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 12;
        $searchQuery = $_GET['search'] ?? '';
        $selectedCategory = isset($_GET['category']) ? (string)$_GET['category'] : '';

        // Get books with search and category filter
        $categoryId = $selectedCategory ? (int)$selectedCategory : null;
        
        if ($searchQuery || $selectedCategory) {
            $allBooks = $bookModel->search($searchQuery, $categoryId);
        } else {
            $allBooks = $bookModel->getAllWithStats($categoryId);
        }

        // Calculate pagination
        $totalBooks = count($allBooks);
        $totalPages = ceil($totalBooks / $perPage);
        $page = min($page, $totalPages ?: 1);
        $offset = ($page - 1) * $perPage;
        $books = array_slice($allBooks, $offset, $perPage);

        // Get categories for filter
        $categories = $categoryModel->all();

        $data = [
            'books'            => $books,
            'categories'       => $categories,
            'searchQuery'      => $searchQuery,
            'selectedCategory' => $selectedCategory,
            'currentPage'      => $page,
            'totalPages'       => $totalPages,
            'totalBooks'       => $totalBooks
        ];

        $this->view('user/books/index', $data);
    }

    // action: user_books_show
    public function userShow(int $id)
    {
        $this->requireAuth();

        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');

        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('user_books_index');
        }

        $data = [
            'book'       => $book,
            'categories' => $categoryModel->all()
        ];

        $this->view('user/books/show', $data);
    }

// action: user_books_search
public function userSearch()
{
    $this->requireAuth();

    $bookModel     = $this->model('Book');
    $categoryModel = $this->model('Category');

    // ---- GET PARAMS ----
    $keyword = trim($_GET['search'] ?? '');
    $categoryId = isset($_GET['category']) && $_GET['category'] !== ''
        ? (int)$_GET['category']
        : null;

    $page    = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $perPage = 12;

    // ---- SEARCH DATA ----
    $allBooks = $bookModel->search($keyword, $categoryId);

    // ---- PAGINATION ----
    $totalBooks = count($allBooks);
    $totalPages = max(1, ceil($totalBooks / $perPage));
    $page       = min($page, $totalPages);
    $offset     = ($page - 1) * $perPage;

    $books = array_slice($allBooks, $offset, $perPage);

    // ---- CATEGORIES (FILTER) ----
    $categories = $categoryModel->all();

    // ---- VIEW DATA ----
    $this->view('user/books/index', [
        'books'            => $books,
        'categories'       => $categories,
        'searchQuery'      => $keyword,
        'selectedCategory' => $categoryId,
        'currentPage'      => $page,
        'totalPages'       => $totalPages,
        'totalBooks'       => $totalBooks
    ]);
}


    // action: user_books_borrow_request
    public function userBorrowRequest(int $id)
    {
        $this->requireAuth();

        $bookModel = $this->model('Book');
        $book = $bookModel->findWithCategory($id);

        if (!$book) {
            $this->redirect('user_books_index');
        }

        $this->view('user/borrow/request', [
            'book' => $book
        ]);
    }

    // ---------- ADMIN METHODS ----------

    // action: admin_books_index
    public function adminIndex()
    {
        $this->requireAdmin();
        $bookModel = $this->model('Book');
        $books = $bookModel->all();  // Giả định lấy tất cả books
        $this->view('admin/books/index', ['books' => $books]);
    }

    // action: admin_books_create
    public function adminCreate()
    {
        $this->requireAdmin();
        $this->view('admin/books/create');
    }

    // action: admin_books_edit
    public function adminEdit($id)
    {
        $this->requireAdmin();
        $bookModel = $this->model('Book');
        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('admin_books_index');
        }
        $this->view('admin/books/edit', ['book' => $book]);
    }

    // action: admin_books_show
    public function adminShow($id)
    {
        $this->requireAdmin();
        $bookModel = $this->model('Book');
        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('admin_books_index');
        }
        $this->view('admin/books/show', ['book' => $book]);
    }
    // action: admin_book_store
    public function adminStore()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin_books_index');
        }

        // Xử lý upload ảnh (giả định)
        $coverImage = null;
        if (!empty($_FILES['cover_image']['name'])) {
            $coverImage = 'uploads/' . time() . '_' . $_FILES['cover_image']['name'];
            move_uploaded_file($_FILES['cover_image']['tmp_name'], APP_PATH . '/public/' . $coverImage);
        }

        $data = [
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'isbn' => $_POST['isbn'],
            'category_id' => $_POST['category_id'],
            'description' => $_POST['description'],
            'quantity' => $_POST['quantity'],
            'cover_image' => $coverImage,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $bookModel = $this->model('Book');
        if ($bookModel->create($data)) {  // Giả định Model có create()
            $this->redirect('admin_books_index');
        } else {
            // Handle error
            $this->redirect('admin_books_create');
        }
    }
    // --- IMPORT VIEW ---
    public function adminImport()
    {
        $this->requireAdmin();
        $this->view('admin/books/import', [
            'active' => 'books'
        ]);
    }

    // --- IMPORT PROCESS (XỬ LÝ FILE EXCEL/CSV với PHPSpreadsheet) ---
    public function adminImportStore()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['import_file'])) {
            $this->redirect('admin_books_import');
            return;
        }

        $file = $_FILES['import_file'];
        
        // Validate file
        if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] == 0) {
            echo "<script>alert('Lỗi upload file!'); window.location.href='index.php?action=admin_books_import';</script>";
            return;
        }

        // Check file extension
        $allowedExtensions = ['xlsx', 'xls', 'csv'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "<script>alert('Chỉ hỗ trợ file Excel (.xlsx, .xls) hoặc CSV!'); window.location.href='index.php?action=admin_books_import';</script>";
            return;
        }

        // Load PHPSpreadsheet
        require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

        try {
            // Create reader based on file type
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Load Models
            $bookModel = $this->model('Book');
            $categoryModel = $this->model('Category');

            // Get option for creating new categories
            $createNewCategory = isset($_POST['create_category']) && $_POST['create_category'] == '1';

            $count = 0;
            $errors = [];
            $skipped = 0;

            // Skip header row (first row)
            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // Skip header

                // Cấu trúc cột: 
                // 0: Title, 1: Author, 2: Category Name, 3: ISBN, 4: Publisher, 5: Year, 6: Quantity, 7: Description

                $title = trim($row[0] ?? '');
                if (empty($title)) {
                    $skipped++;
                    continue; // Bỏ qua nếu không có tiêu đề sách
                }

                // Xử lý Category
                $catName = trim($row[2] ?? '');
                $categoryId = null;

                if (!empty($catName)) {
                    // Tìm category theo tên
                    $category = $categoryModel->findByName($catName);
                    
                    if ($category) {
                        $categoryId = $category['category_id'];
                    } elseif ($createNewCategory) {
                        // Tạo category mới nếu được phép
                        $categoryId = $categoryModel->createCategory($catName);
                    }
                }

                // Nếu không tìm thấy và không tạo mới, dùng category mặc định (ID = 1)
                if (!$categoryId) {
                    $categoryId = 1;
                }

                // Validate và xử lý dữ liệu
                $author = trim($row[1] ?? '');
                $isbn = trim($row[3] ?? '');
                $publisher = trim($row[4] ?? '');
                $year = $row[5] ?? '';
                $quantity = $row[6] ?? 0;
                $description = trim($row[7] ?? '');

                $data = [
                    'title'          => $title,
                    'author'         => !empty($author) ? $author : 'Unknown',
                    'category_id'    => $categoryId,
                    'isbn'           => $isbn,
                    'publisher'      => $publisher,
                    'published_year' => is_numeric($year) ? (int)$year : date('Y'),
                    'quantity'       => is_numeric($quantity) ? (int)$quantity : 0,
                    'description'    => $description,
                    'cover_image'    => 'images/books/default.jpg'
                ];

                // Tạo sách mới
                if ($bookModel->create($data)) {
                    $count++;
                } else {
                    $errors[] = "Lỗi import dòng " . ($index + 1) . ": $title";
                }
            }

            // Thông báo kết quả
            $message = "Import thành công $count sách!";
            if ($skipped > 0) {
                $message .= " ($skipped dòng bị bỏ qua do thiếu tiêu đề)";
            }
            if (!empty($errors)) {
                $message .= " Có " . count($errors) . " lỗi.";
            }

            echo "<script>alert('$message'); window.location.href='index.php?action=admin_books_index';</script>";
            return;

        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            echo "<script>alert('Lỗi đọc file: " . addslashes($e->getMessage()) . "'); window.location.href='index.php?action=admin_books_import';</script>";
            return;
        } catch (\Exception $e) {
            echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "'); window.location.href='index.php?action=admin_books_import';</script>";
            return;
        }
    }

    // --- DOWNLOAD SAMPLE EXCEL FILE ---
    public function adminImportSample()
    {
        $this->requireAdmin();

        require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Books Import Template');

        // Header row
        $headers = ['Title', 'Author', 'Category Name', 'ISBN', 'Publisher', 'Year', 'Quantity', 'Description'];
        $sheet->fromArray($headers, null, 'A1');

        // Style header row
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

        // Sample data rows
        $sampleData = [
            ['The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', '978-0743273565', 'Scribner', 1925, 5, 'A novel about the American Dream'],
            ['Clean Code', 'Robert C. Martin', 'Programming', '978-0132350884', 'Prentice Hall', 2008, 3, 'A handbook of agile software craftsmanship'],
            ['1984', 'George Orwell', 'Fiction', '978-0451524935', 'Signet Classic', 1949, 4, 'A dystopian social science fiction novel'],
        ];
        $sheet->fromArray($sampleData, null, 'A2');

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Output file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="books_import_template.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    
}