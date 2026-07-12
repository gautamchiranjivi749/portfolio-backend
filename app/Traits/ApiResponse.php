<?php

namespace App\Traits;

trait ApiResponse
{
     public function successResponse(
        $data = null,
        $message = 'Success',
        $status = 200
    )
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
      public function errorResponse(
        $message = 'Something went wrong.',
        $status = 400,
        $errors = null
    ) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
      public function paginatedResponse(
        $resource,
        $pagination,
        $message = 'Success'
    ) {
        return response()->json([
            'success' => true,
            'message' => $message,

            'data' => $resource,

            'pagination' => [
                'current_page' => $pagination->currentPage(),
                'last_page'    => $pagination->lastPage(),
                'per_page'     => $pagination->perPage(),
                'total'        => $pagination->total(),
                'from'         => $pagination->firstItem(),
                'to'           => $pagination->lastItem(),
            ],
        ]);
    }
}
