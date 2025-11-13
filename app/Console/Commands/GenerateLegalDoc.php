<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateLegalDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legal:generate {complaint_id} {type=complaint_acknowledgment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate legal documents for complaints';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $complaintId = $this->argument('complaint_id');
        $type = $this->argument('type');

        $complaint = \App\Models\Complaint::with(['user', 'assignedOfficial'])->find($complaintId);

        if (!$complaint) {
            $this->error('Complaint not found!');
            return 1;
        }

        $this->info("Generating {$type} document for complaint #{$complaintId}");

        // Generate document based on type
        switch ($type) {
            case 'complaint_acknowledgment':
                $this->generateAcknowledgment($complaint);
                break;
            case 'resolution_certificate':
                $this->generateResolutionCertificate($complaint);
                break;
            default:
                $this->error('Unknown document type!');
                return 1;
        }

        $this->info('Document generated successfully!');
        return 0;
    }

    private function generateAcknowledgment($complaint)
    {
        $content = $this->getAcknowledgmentTemplate($complaint);
        $filename = "complaint_acknowledgment_{$complaint->id}.pdf";

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($content);
        $pdf->save(storage_path("app/public/legal_docs/{$filename}"));

        $this->info("Acknowledgment saved as: storage/app/public/legal_docs/{$filename}");
    }

    private function generateResolutionCertificate($complaint)
    {
        if ($complaint->status !== 'resolved') {
            $this->error('Complaint must be resolved to generate resolution certificate!');
            return;
        }

        $content = $this->getResolutionTemplate($complaint);
        $filename = "resolution_certificate_{$complaint->id}.pdf";

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($content);
        $pdf->save(storage_path("app/public/legal_docs/{$filename}"));

        $this->info("Resolution certificate saved as: storage/app/public/legal_docs/{$filename}");
    }

    private function getAcknowledgmentTemplate($complaint)
    {
        return "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; margin-bottom: 30px; }
                .content { line-height: 1.6; }
                .signature { margin-top: 50px; text-align: center; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>Republic of the Philippines</h2>
                <h3>Barangay Complaint Acknowledgment</h3>
                <p>Date: " . now()->format('F d, Y') . "</p>
            </div>

            <div class='content'>
                <p>This is to acknowledge receipt of the complaint filed by:</p>

                <p><strong>Complainant:</strong> {$complaint->user->name}</p>
                <p><strong>Address:</strong> Purok {$complaint->purok}, {$complaint->street}, {$complaint->sitio}</p>
                <p><strong>Complaint Category:</strong> {$complaint->category}</p>
                <p><strong>Details:</strong> {$complaint->details}</p>

                <p>The complaint has been assigned reference number <strong>{$complaint->id}</strong> and will be processed accordingly.</p>

                <p>Status: {$complaint->status}</p>
            </div>

            <div class='signature'>
                <p>_______________________________</p>
                <p>Barangay Official</p>
            </div>
        </body>
        </html>
        ";
    }

    private function getResolutionTemplate($complaint)
    {
        return "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; margin-bottom: 30px; }
                .content { line-height: 1.6; }
                .signature { margin-top: 50px; text-align: center; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h2>Republic of the Philippines</h2>
                <h3>Barangay Resolution Certificate</h3>
                <p>Date: " . now()->format('F d, Y') . "</p>
            </div>

            <div class='content'>
                <p>This certifies that the complaint filed by:</p>

                <p><strong>Complainant:</strong> {$complaint->user->name}</p>
                <p><strong>Address:</strong> Purok {$complaint->purok}, {$complaint->street}, {$complaint->sitio}</p>
                <p><strong>Complaint Category:</strong> {$complaint->category}</p>
                <p><strong>Details:</strong> {$complaint->details}</p>

                <p>Has been <strong>RESOLVED</strong> as of " . ($complaint->status_updated_at ? $complaint->status_updated_at->format('F d, Y') : now()->format('F d, Y')) . ".</p>

                <p>Reference Number: {$complaint->id}</p>
            </div>

            <div class='signature'>
                <p>_______________________________</p>
                <p>Barangay Captain</p>
            </div>
        </body>
        </html>
        ";
    }
}
