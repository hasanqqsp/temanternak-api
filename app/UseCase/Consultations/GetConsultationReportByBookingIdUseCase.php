<?php

namespace App\UseCase\Consultations;

use App\Domain\Consultations\ConsultationRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Infrastructure\Repository\Storage\S3Compatible\S3FileRepository;
use Barryvdh\DomPDF\PDF;
use Illuminate\View\FileViewFinder;

class GetConsultationReportByBookingIdUseCase
{
    private $consultationRepository;
    private $bookingRepository;
    private $pdfService;
    private $s3FileRepository;

    public function __construct(ConsultationRepository $consultationRepository, ServiceBookingRepository $bookingRepository, S3FileRepository $s3FileRepository,  $pdfService)
    {
        $this->consultationRepository = $consultationRepository;
        $this->bookingRepository = $bookingRepository;
        $this->s3FileRepository = $s3FileRepository;
        $this->pdfService = $pdfService;
    }

    public function execute(string $bookingId, string $credentialId, $timezone)
    {
        $this->bookingRepository->checkIfExists($bookingId);
        $this->bookingRepository->checkIfAuthorized($bookingId, $credentialId);
        try {
            return $this->consultationRepository->getReport($bookingId);
        } catch (\Exception $e) {
            // do nothing
            $data = $this->consultationRepository->getDetail($bookingId)->toArray();
            $data['timezone'] = $timezone;
            $this->pdfService::setOptions(['isRemoteEnabled' => true]);
            $pdf = $this->pdfService::loadView('consultation-report', $data);

            $filePath = $this->s3FileRepository->uploadPdf($pdf->output(), $data["id"], 'consultation-report');
            $this->consultationRepository->addReport($bookingId, $filePath);
            return $filePath;
        }
    }
}
