<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Review\Entities\NewReview;
use App\Domain\Review\ReviewRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\UseCase\Reviews\AddReviewByBookingIdUseCase;
use App\UseCase\Reviews\GetAllReviewUseCase;
use App\UseCase\Reviews\GetReviewByBookingIdUseCase;
use App\UseCase\Reviews\GetReviewByServiceIdUseCase;
use App\UseCase\Reviews\GetReviewByVeterinarianIdUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReviewsController extends Controller
{
    private $addReviewByBookingIdUseCase;
    private $getReviewByBookingIdUseCase;
    private $getAllReviewUseCase;
    private $getReviewByServiceIdUseCase;
    private $getReviewByVeterinarianIdUseCase;

    public function __construct(ReviewRepository $reviewRepository, ServiceBookingRepository $bookingRepository)
    {
        $this->addReviewByBookingIdUseCase =  new AddReviewByBookingIdUseCase($reviewRepository, $bookingRepository);
        $this->getAllReviewUseCase =  new GetAllReviewUseCase($reviewRepository);
        $this->getReviewByServiceIdUseCase = new GetReviewByServiceIdUseCase($reviewRepository);
        $this->getReviewByVeterinarianIdUseCase = new GetReviewByVeterinarianIdUseCase($reviewRepository);
        $this->getReviewByBookingIdUseCase = new GetReviewByBookingIdUseCase($reviewRepository);
    }

    public function add(Request $request, $bookingId)
    {
        $this->addReviewByBookingIdUseCase->execute(
            new NewReview(
                $bookingId,
                $request->review,
                $request->stars
            ),
            $request->user()->id
        );

        return [
            "status" => "success",
            "message" => "Review added succesfully"
        ];
    }

    public function getAll()
    {
        return [
            "status" => "success",
            "data" => $this->getAllReviewUseCase->execute()
        ];
    }
    public function getByVeterinarianId($veterinarianId)
    {
        return [
            "status" => "success",
            "data" => $this->getReviewByVeterinarianIdUseCase->execute($veterinarianId)->toArray()
        ];
    }

    public function getByServiceId($serviceId)
    {
        return [
            "status" => "success",
            "data" => $this->getReviewByServiceIdUseCase->execute($serviceId)
        ];
    }
    public function getByBookingId($bookingId)
    {
        return [
            "status" => "success",
            "data" => $this->getReviewByBookingIdUseCase->execute($bookingId)->toArray()
        ];
    }
}
