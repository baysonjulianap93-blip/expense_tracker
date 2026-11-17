<?php
// Categories: list, add, edit, delete
class CategoryController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();

        $this->render('categories', [
            'active'     => 'categories',
            'pageTitle'  => 'Categories',
            'categories' => (new Category())->allWithTransactionCount(),
            'message'    => $_GET['msg'] ?? '',
            'error'      => $_GET['err'] ?? '',
        ]);
    }

    public function create(): void
    {
        $this->form(null);
    }

    public function edit(): void
    {
        $this->requireLogin();
        $category = (new Category())->find((int)($_GET['id'] ?? 0));

        if (!$category) {
            $this->redirectTo('categories', ['err' => 'Category not found.']);
        }
        $this->form($category);
    }

    public function delete(): void
    {
        $this->requireLogin();
        $id = (int)($_POST['category_id'] ?? 0);

        if (!$this->isPost() || $id <= 0) {
            $this->redirectTo('categories');
        }

        $categories = new Category();
        if ($categories->isUsedByTransactions($id)) {
            $this->redirectTo('categories', ['err' => 'This category is used by existing transactions. Reassign or delete those first.']);
        }
        $categories->delete($id);
        $this->redirectTo('categories', ['msg' => 'Category deleted.']);
    }

    // Shared by Add ($existing = null) and Edit ($existing = the row)
    private function form(?array $existing): void
    {
        $this->requireLogin();
        $error = '';
        $name  = $existing['category_name'] ?? '';

        if ($this->isPost()) {
            $name = trim($_POST['category_name'] ?? '');

            if ($name === '') {
                $error = 'Category name is required.';
            } else {
                try {
                    if ($existing) {
                        (new Category())->update($existing['category_id'], $name);
                        $this->redirectTo('categories', ['msg' => 'Category updated.']);
                    }
                    (new Category())->create($name);
                    $this->redirectTo('categories', ['msg' => 'Category added.']);
                } catch (PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            }
        }

        $heading = $existing ? 'Edit Category' : 'Add Category';
        $this->render('category_form', [
            'active'      => 'categories',
            'pageTitle'   => $heading,
            'heading'     => $heading,
            'submitLabel' => $existing ? 'Save Changes' : 'Save Category',
            'name'        => $name,
            'error'       => $error,
        ]);
    }
}
