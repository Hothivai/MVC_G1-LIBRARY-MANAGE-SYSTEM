<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Book.php';
use App\Core\Database;

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

        $this->view('admin/books/index', $data);
    }

    // action: admin_books_create
    public function adminCreate()
    {
        $this->requireAdmin();
        $categoryModel = $this->model('Category');
        $categories = $categoryModel->all();
        $this->view('admin/books/create', ['categories' => $categories]);
    }

    // action: admin_books_edit
    public function adminEdit($id)
    {
        $this->requireAdmin();
        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');
        
        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('admin_books_index');
        }
        
        $categories = $categoryModel->all();
        $this->view('admin/books/edit', [
            'book' => $book,
            'categories' => $categories
        ]);
    }

    // action: admin_books_show
    public function adminShow($id)
    {
        $this->requireAdmin();
        $bookModel = $this->model('Book');
        $transactionModel = $this->model('Transaction');
        
        $book = $bookModel->find($id);
        if (!$book) {
            $this->redirect('admin_books_index');
        }
        
        // Get borrowing history for this book
        $history = $transactionModel->getHistoryByBook($id);
        
        $this->view('admin/books/show', [
            'book' => $book,
            'history' => $history
        ]);
    }

    // action: admin_books_delete
    public function adminDelete($id)
    {
        $this->requireAdmin();
        
        $bookModel = $this->model('Book');
        $book = $bookModel->find($id);
        
        if (!$book) {
            $this->redirect('admin_books_index');
        }

        // Xóa ảnh nếu có
        if (!empty($book['image_url'])) {
            $imagePath = dirname(APP_PATH) . '/public/' . $book['image_url'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Xóa các book_copies liên quan trước
        $this->deleteBookCopies($id);

        // Xóa sách
        if ($bookModel->delete($id)) {
            // Thông báo thành công (có thể dùng session flash message)
            header('Location: index.php?action=admin_books_index&deleted=1');
            exit;
        } else {
            // Thông báo lỗi
            header('Location: index.php?action=admin_books_index&error=1');
            exit;
        }
    }
    // action: admin_book_store
    public function adminStore()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin_books_index');
        }

        $bookModel = $this->model('Book');
        $bookId = isset($_POST['book_id']) ? (int)$_POST['book_id'] : null;
        $isUpdate = !empty($bookId);

        // Xử lý upload ảnh
        $imageUrl = null;
        if (!empty($_FILES['cover_image']['name'])) {
            $uploadDir = dirname(APP_PATH) . '/public/images/books/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newFileName = time() . '_' . uniqid() . '.jpg';
            $targetPath = $uploadDir . $newFileName;
            $this->convertToJpg($_FILES['cover_image']['tmp_name'], $targetPath);
            $imageUrl = 'images/books/' . $newFileName;
        } elseif ($isUpdate) {
            $existingBook = $bookModel->find($bookId);
            $imageUrl = $existingBook['image_url'] ?? $existingBook['cover_image'] ?? null;
        }

        $data = [
            'title' => $_POST['title'] ?? '',
            'author' => $_POST['author'] ?? '',
            'isbn' => $_POST['isbn'] ?? '',
            'category_id' => $_POST['category_id'] ?? null,
            'description' => $_POST['description'] ?? '',
            'publisher' => $_POST['publisher'] ?? '',
            'published_year' => isset($_POST['published_year']) ? (int)$_POST['published_year'] : null
        ];

        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($imageUrl !== null) {
            $data['image_url'] = $imageUrl;
        }

        if ($isUpdate) {
            // Update logic remains the same for now
            if ($bookModel->update($bookId, $data)) {
                $this->setFlash('success', 'Cập nhật sách thành công!');
                $this->redirect('admin_books_index');
            } else {
                $this->setFlash('error', 'Cập nhật sách thất bại.');
                $this->redirect('admin_books_edit&id=' . $bookId);
            }
        } else {
            // Create new book
            try {
                $data['created_at'] = date('Y-m-d H:i:s');
                if ($bookModel->create($data)) {
                    $newBookId = $this->db->lastInsertId();
                    
                    if ($quantity > 0 && $newBookId) {
                        $this->createBookCopies($newBookId, $quantity);
                    }
                    
                    $this->setFlash('success', 'Thêm sách thành công!');
                    $this->redirect('admin_books_index');
                } else {
                    $this->setFlash('error', 'Thêm sách thất bại. Vui lòng thử lại.');
                    $this->redirect('admin_books_create');
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) { // Integrity constraint violation
                    $this->setFlash('error', 'Lỗi: Sách với mã ISBN "' . htmlspecialchars($data['isbn']) . '" đã tồn tại.');
                } else {
                    // Log the error for the admin, show a generic message to the user
                    error_log('Book creation error: ' . $e->getMessage());
                    $this->setFlash('error', 'Đã xảy ra lỗi khi thêm sách. Vui lòng liên hệ quản trị viên.');
                }
                $this->redirect('admin_books_create');
            }
        }
    }

    /**
     * Tạo các bản copy của sách
     */
    private function createBookCopies(int $bookId, int $quantity): void
    {
        $db = Database::getInstance()->getConnection();
        
        for ($i = 0; $i < $quantity; $i++) {
            $barcode = 'BC' . str_pad($bookId, 6, '0', STR_PAD_LEFT) . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            
            $sql = "INSERT INTO book_copies (book_id, barcode, status) VALUES (?, ?, 'available')";
            $stmt = $db->prepare($sql);
            $stmt->execute([$bookId, $barcode]);
        }
    }
    

    /**
     * Xóa các bản copy của sách
     */
    private function deleteBookCopies(int $bookId): void
    {
        $db = Database::getInstance()->getConnection();
        $sql = "DELETE FROM book_copies WHERE book_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bookId]);
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

    // 1. Kiểm tra Request và File
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['import_file'])) {
        $this->redirect('admin_books_import');
        return;
    }

    $file = $_FILES['import_file'];
    
    // 2. Validate lỗi upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $uploadErrors = [
            UPLOAD_ERR_INI_SIZE   => 'File vượt quá giới hạn upload của server.',
            UPLOAD_ERR_FORM_SIZE  => 'File quá lớn.',
            UPLOAD_ERR_PARTIAL    => 'File chỉ upload một phần.',
            UPLOAD_ERR_NO_FILE    => 'Chưa chọn file.',
            UPLOAD_ERR_NO_TMP_DIR => 'Thiếu thư mục tạm.',
            UPLOAD_ERR_CANT_WRITE => 'Không ghi được file.',
        ];
        $msg = $uploadErrors[$file['error']] ?? 'Lỗi upload không xác định.';
        $this->alertRedirect($msg, 'admin_books_import');
        return;
    }

    // 3. Kiểm tra định dạng file
    $allowedExtensions = ['xlsx', 'xls', 'csv'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        $this->alertRedirect('Chỉ hỗ trợ file Excel (.xlsx, .xls) hoặc CSV!', 'admin_books_import');
        return;
    }

    // 4. Kiểm tra Composer Autoload
    $vendorAutoload = dirname(__DIR__, 2) . '/vendor/autoload.php';
    if (!file_exists($vendorAutoload)) {
        $this->alertRedirect('Thư viện PhpSpreadsheet chưa được cài đặt.', 'admin_books_import');
        return;
    }
    require_once $vendorAutoload;

    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file['tmp_name']);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $bookModel = $this->model('Book');
        $categoryModel = $this->model('Category');
        $createNewCategory = isset($_POST['create_category']) && $_POST['create_category'] == '1';

        $count = 0;
        $skipped = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Bỏ qua tiêu đề

            $title    = trim($row[0] ?? '');
            $isbn     = trim($row[3] ?? '');
            
            // Validate dữ liệu tối thiểu
            if (empty($title)) {
                $skipped++;
                continue;
            }

            // KIỂM TRA ISBN (Đã chuyển vào trong vòng lặp)
            if (!empty($isbn)) {
                $existing = $bookModel->findByIsbn($isbn);
                if ($existing) {
                    $skipped++;
                    continue; 
                }
            }

            // Xử lý Category
            $catName = trim($row[2] ?? '');
            $categoryId = 1; // Mặc định

            if (!empty($catName)) {
                $category = $categoryModel->findByName($catName);
                if ($category) {
                    $categoryId = $category['category_id'];
                } elseif ($createNewCategory) {
                    $categoryId = $categoryModel->createCategory($catName);
                }
            }

            // Chuẩn bị dữ liệu
            $author    = trim($row[1] ?? 'Unknown');
            $publisher = trim($row[4] ?? '');
            $year      = $row[5] ?? date('Y');
            $quantity  = (int)($row[6] ?? 0);
            $desc      = trim($row[7] ?? '');

            $data = [
                'title'          => $title,
                'author'         => $author,
                'category_id'    => $categoryId,
                'isbn'           => $isbn,
                'publisher'      => $publisher,
                'published_year' => is_numeric($year) ? (int)$year : date('Y'),
                'description'    => $desc,
                'image_url'      => 'images/books/default.jpg'
            ];

            // Thực hiện thêm vào DB
            try {
                // Giả sử $bookModel->create trả về ID hoặc dùng lastInsertId
                $newBookId = $bookModel->create($data); 
                
                if ($newBookId) {
                    // Nếu create() trả về true thay vì ID, lấy từ DB
                    if ($newBookId === true) {
                        $newBookId = $this->db->lastInsertId();
                    }

                    // Tạo bản sao sách
                    if ($quantity > 0) {
                        $this->createBookCopies($newBookId, $quantity);
                    }
                    $count++;
                } else {
                    $errors[] = "Dòng " . ($index + 1) . ": Không thể lưu vào database.";
                }
            } catch (\Exception $e) {
                $errors[] = "Dòng " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        // Thông báo kết quả
        $msg = "Import hoàn tất! Thành công: $count.";
        if ($skipped > 0) $msg .= " Bỏ qua: $skipped (Trùng ISBN hoặc trống tên).";
        if (count($errors) > 0) $msg .= " Lỗi: " . count($errors);

        $this->alertRedirect($msg, 'admin_books_index');

    } catch (\Exception $e) {
        $this->alertRedirect('Lỗi hệ thống: ' . $e->getMessage(), 'admin_books_import');
    }
}

    // --- DOWNLOAD SAMPLE EXCEL FILE ---
    public function adminImportSample()
    {
        $this->requireAdmin();

        $vendorAutoload = dirname(__DIR__, 2) . '/vendor/autoload.php';
        if (!file_exists($vendorAutoload)) {
            $this->alertRedirect('Thư viện Excel chưa được cài. Vui lòng chạy: composer install', 'admin_books_import');
            return;
        }
        require_once $vendorAutoload;

        // Tránh "headers already sent": xóa output buffer trước khi gửi file
        while (ob_get_level()) {
            ob_end_clean();
        }

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
        header('Content-Disposition: attachment; filename="books_import_template.xlsx"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    /**
     * Hiển thị alert và redirect (dùng URL tương đối để tránh 404)
     */
    private function alertRedirect(string $message, string $action): void
    {
        $msg = addslashes($message);
        echo "<script>alert('" . $msg . "'); window.location.href='index.php?action=" . $action . "';</script>";
        exit;
    }

    /**
     * Convert ảnh sang định dạng JPG
     * Nếu GD extension không có, chỉ copy file và đổi tên thành .jpg
     */
    private function convertToJpg(string $sourcePath, string $targetPath): bool
    {
        // Kiểm tra xem GD extension có sẵn không
        if (!extension_loaded('gd')) {
            // Nếu không có GD, chỉ copy file và đổi tên
            return copy($sourcePath, $targetPath);
        }

        // Lấy thông tin ảnh
        $imageInfo = getimagesize($sourcePath);
        if ($imageInfo === false) {
            // Nếu không đọc được ảnh, copy file trực tiếp
            return copy($sourcePath, $targetPath);
        }

        $mimeType = $imageInfo['mime'];

        // Tạo image resource từ file gốc
        $sourceImage = false;
        switch ($mimeType) {
            case 'image/jpeg':
                if (function_exists('imagecreatefromjpeg')) {
                    $sourceImage = imagecreatefromjpeg($sourcePath);
                }
                break;
            case 'image/png':
                if (function_exists('imagecreatefrompng')) {
                    $sourceImage = imagecreatefrompng($sourcePath);
                }
                break;
            case 'image/gif':
                if (function_exists('imagecreatefromgif')) {
                    $sourceImage = imagecreatefromgif($sourcePath);
                }
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $sourceImage = imagecreatefromwebp($sourcePath);
                }
                break;
        }

        // Nếu không tạo được image resource, copy file trực tiếp
        if ($sourceImage === false) {
            return copy($sourcePath, $targetPath);
        }

        // Tạo ảnh mới với chất lượng JPG
        if (!function_exists('imagejpeg')) {
            imagedestroy($sourceImage);
            return copy($sourcePath, $targetPath);
        }

        $result = imagejpeg($sourceImage, $targetPath, 85); // 85% quality
        
        // Giải phóng bộ nhớ
        imagedestroy($sourceImage);

        return $result;
    }
    
}