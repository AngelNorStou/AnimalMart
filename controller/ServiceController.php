<?php
require_once '../model/ServiceModel.php';

class ServiceController
{
    private ServiceModel $serviceObj;
    private PDO $conn;

    public function __construct(ServiceModel $serviceObj, PDO $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->serviceObj = $serviceObj;
        $this->conn = $db;
    }



    public function getServices(int $limit, int $offset): array
    {
        return $this->serviceObj->getServices($limit, $offset);
    }

    public function displayAllServices(): array
    {
        return $this->serviceObj->displayService();
    }

    public function serviceType(): array
    {
        return $this->serviceObj->getServiceType();
    }



    private function getTotalPages(int $resultsPerPage): int
    {
        if ($resultsPerPage <= 0) {
            return 1;
        }

        $total = $this->serviceObj->getTotalServiceCount();
        return (int) ceil($total / $resultsPerPage);
    }

    public function displayPagination(int $resultsPerPage): string
    {
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page'])
            ? max(1, (int) $_GET['page'])
            : 1;

        $totalPages = $this->getTotalPages($resultsPerPage);

        if ($totalPages <= 1) {
            return '';
        }

        $html = '<nav class="flex justify-center mt-6"><ul class="flex flex-row space-x-1">';

        for ($page = 1; $page <= $totalPages; $page++) {
            $classes = $page === $currentPage
                ? 'px-3 py-1 rounded bg-blue-600 text-white font-semibold'
                : 'px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-blue-50';
            $html .= sprintf(
                '<li><a class="%s" href="services.php?page=%d">%d</a></li>',
                $classes,
                $page,
                $page
            );
        }

        $html .= '</ul></nav>';

        return $html;
    }



    public function getServiceById(?int $id = null): ?array
    {
        if ($id === null) {
            if (!isset($_GET['service']) || !is_numeric($_GET['service'])) {
                return null;
            }
            $id = (int) $_GET['service'];
        }

        if ($id <= 0) {
            return null;
        }

        return $this->serviceObj->displayServiceById($id);
    }



    public function addService(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_POST['addService'], $_POST['type'], $_POST['name'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }

        return $this->serviceObj->addService($_POST);
    }



    public function editService(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_POST['editService'], $_POST['service_id'], $_POST['name'])) {
            return ['success' => false, 'message' => 'Missing required fields'];
        }

        return $this->serviceObj->editService($_POST);
    }



    public function deleteService(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        if (!isset($_POST['deleteService'], $_POST['service_id']) || !is_numeric($_POST['service_id'])) {
            return ['success' => false, 'message' => 'Invalid service ID'];
        }

        return $this->serviceObj->deleteService((int) $_POST['service_id']);
    }



    public function search(): array
    {
        if (!isset($_GET['searchInput'])) {
            return [];
        }

        $search = trim($_GET['searchInput']);

        if ($search === '') {
            return [];
        }

        return $this->serviceObj->searchServices($search);
    }
}
