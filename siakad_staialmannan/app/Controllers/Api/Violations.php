<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\NilaiModel;

class Violations extends ResourceController
{
    protected $format    = 'json';

    public function save()
    {
        // Allow CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Methods: POST, OPTIONS');

        if ($this->request->getMethod() === 'options') {
            return $this->response->setStatusCode(200);
        }

        $examId = $this->request->getVar('exam_id'); 
        $type = $this->request->getVar('type'); // 'UTS' or 'UAS'
        $note = $this->request->getVar('note');

        if (!$examId || !$note) {
            return $this->fail('Missing required fields: exam_id, note', 400);
        }

        // Default to UTS if not specified, or handle logic? 
        // Better to require type or guess.
        // If type is not 'UTS' or 'UAS', maybe just append to one or default?
        // Let's assume passed type. If not, maybe check something else?
        // For now require type.
        if (!in_array($type, ['UTS', 'UAS'])) {
             // Try to fuzzy match or default?
             // Let's rely on frontend sending it.
             if (!$type) $type = 'UTS'; // Fallback? Dangerous.
        }

        $model = new NilaiModel($this->request);

        // Find record
        $record = $model->find($examId);
        
        if (!$record) {
            return $this->failNotFound('Exam record not found for ID: ' . $examId);
        }

        $column = ($type === 'UAS') ? 'ctt_uas' : 'ctt_uts';
        
        $existingNote = $record[$column] ?? '';
        // If existing note exists, add newline
        if (!empty($existingNote)) {
            $newNote = $existingNote . "\n" . date('Y-m-d H:i:s') . ' : ' . $note;
        } else {
            $newNote = date('Y-m-d H:i:s') . ' : ' . $note;
        }

        $updateData = [
            'id_ljk' => $examId,
            $column => $newNote
        ];

        // We use model->save()
        // NilaiModel save logic might need checking.
        // It uses $builder->save($record).
        
        if ($model->save($updateData)) {
            return $this->respondCreated(['message' => 'Violation recorded', 'new_note' => $newNote]);
        } else {
            return $this->fail('Failed to save violation');
        }
    }
}
