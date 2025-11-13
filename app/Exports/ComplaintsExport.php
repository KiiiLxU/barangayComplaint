<?php

namespace App\Exports;

use App\Models\Complaint;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ComplaintsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Complaint::with(['user', 'assignedOfficial']);

        // Apply filters
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'User Name',
            'User Email',
            'Category',
            'Details',
            'Sitio',
            'Purok',
            'Street',
            'Status',
            'Assigned Official',
            'Created At',
            'Updated At',
        ];
    }

    public function map($complaint): array
    {
        return [
            $complaint->id,
            $complaint->user->name ?? '',
            $complaint->user->email ?? '',
            $complaint->category,
            $complaint->details,
            $complaint->sitio,
            $complaint->purok,
            $complaint->street,
            $complaint->status,
            $complaint->assignedOfficial->name ?? '',
            $complaint->created_at->format('Y-m-d H:i:s'),
            $complaint->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
