<?php

namespace Modules\Payment\Http\Controllers\Api;

use App\Traits\TapPaymentTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Entities\User;
use Modules\Course\Entities\Course;

class PaymentController extends Controller
{
    use TapPaymentTrait;

    public function createPayment(Request $request)
    {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 400);
        }

        $course = Course::findOrFail($request->course_id);

        $paymentData = $this->preparePaymentData($course, $user);

        $response = $this->createCharge($paymentData);

        if (isset($response['transaction']['url'])) {
            return response()->json([
                'redirect_url' => $response['transaction']['url'],
            ]);
        }

        return response()->json(['error' => 'Payment initialization failed'], 500);
    }

    public function handlePaymentResponse(Request $request)
    {
        $tapId = $request->tap_id;

        if (!$tapId) {
            return response()->json(['message' => 'No tap_id found'], 400);
        }

        $charge = $this->retrieveCharge($tapId);

        if ($this->isPaymentSuccessful($charge)) {
            return $this->processSuccessfulPayment($charge);
        }

        return response()->json(['status' => 'failed'], 400);
    }

    private function getAuthenticatedUser()
    {
        return User::find(sanctum()->id());
    }

    private function preparePaymentData(Course $course, User $user)
    {
        return [
            'amount' => $course->price,
            'currency' => 'SAR',
            'threeDSecure' => true,
            'save_card' => false,
            'description' => 'Course Purchase',
            'statement_descriptor' => 'COURSE_PURCHASE',
            'customer' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'source' => [
                'id' => 'src_all',
            ],
            'post' => [
                'url' => route('payment.handleResponse'),
            ],
            'redirect' => [
                'url' => route('payment.handleResponse'),
            ],
            'metadata' => [
                'course_id' => $course->id,
                'user_id' => $user->id,
            ],
        ];
    }

    private function isPaymentSuccessful(array $charge)
    {
        return isset($charge['status']) && $charge['status'] == 'CAPTURED';
    }

    private function processSuccessfulPayment(array $charge)
    {
        $user = User::find($charge['metadata']['user_id']);

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 400);
        }

        $courseId = $charge['metadata']['course_id'] ?? null;

        if (!$courseId) {
            return response()->json(['error' => 'Course ID not found in charge metadata'], 400);
        }

        $this->addCourseToUser($user, $courseId);

        return response()->json(['status' => 'success']);
    }

    private function addCourseToUser(User $user, int $courseId)
    {
        $user->courses()->attach($courseId, ['created_at' => now(), 'updated_at' => now()]);
    }
}
