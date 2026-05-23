<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $peran = session()->get('peran');

        if ($arguments !== null) {
            if (!in_array($peran, $arguments)) {
                return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
} 