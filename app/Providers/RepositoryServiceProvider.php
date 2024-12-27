<?php

namespace App\Providers;

use App\Repositories\FeeRepository;
use App\Repositories\ExamRepository;
use App\Repositories\QuizzeRepository;
use App\Repositories\LibraryRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\QuestionRepository;
use App\Repositories\FeeInvoicesRepository;
use App\Repositories\FeeRepositoryInterface;
use App\Repositories\ExamRepositoryInterface;
use App\Repositories\ProcessingFeeRepository;
use App\Repositories\PaymentStudentRepository;
use App\Repositories\StudentReceiptRepository;
use App\Repositories\QuizzeRepositoryInterface;
use App\Repositories\GraduatedStudentRepository;
use App\Repositories\LibraryRepositoryInterface;
use App\Repositories\StudentPromotionRepository;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\SubjectRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\QuestionRepositoryInterface;
use App\Repositories\StudentAttendanceRepository;
use App\Repositories\FeeInvoicesRepositoryInterface;
use App\Repositories\ProcessingFeeRepositoryInterface;
use App\Repositories\PaymentStudentRepositoryInterface;
use App\Repositories\StudentReceiptRepositoryInterface;
use App\Repositories\GraduatedStudentRepositoryInterface;
use App\Repositories\StudentPromotionRepositoryInterface;
use App\Repositories\StudentAttendanceRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        /**
         * Binds the TeacherRepositoryInterface contract to the TeacherRepository implementation.
         * This allows the application to use the TeacherRepository class whenever the
         * TeacherRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            TeacherRepositoryInterface::class,
            TeacherRepository::class,
        );

        /**
         * Binds the StudentRepositoryInterface contract to the StudentRepository implementation.
         * This allows the application to use the StudentRepository class whenever the
         * StudentRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            StudentRepositoryInterface::class,
            StudentRepository::class,
        );

        /**
         * Binds the StudentPromotionRepositoryInterface contract to the StudentPromotionRepository implementation.
         * This allows the application to use the StudentPromotionRepository class whenever the
         * StudentPromotionRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            StudentPromotionRepositoryInterface::class,
            StudentPromotionRepository::class,
        );

        /**
         * Binds the GraduatedStudentRepositoryInterface contract to the GraduatedStudentRepository implementation.
         * This allows the application to use the GraduatedStudentRepository class whenever the
         * GraduatedStudentRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            GraduatedStudentRepositoryInterface::class,
            GraduatedStudentRepository::class
        );

        /**
         * Binds the FeeRepositoryInterface contract to the FeeRepository implementation.
         * This allows the application to use the FeeRepository class whenever the
         * FeeRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            FeeRepositoryInterface::class,
            FeeRepository::class
        );

        /**
         * Binds the FeeInvoicesRepositoryInterface contract to the FeeInvoicesRepository implementation.
         * This allows the application to use the FeeInvoicesRepository class whenever the
         * FeeInvoicesRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            FeeInvoicesRepositoryInterface::class,
            FeeInvoicesRepository::class
        );

        /**
         * Binds the StudentReceiptRepositoryInterface contract to the StudentReceiptRepository implementation.
         * This allows the application to use the StudentReceiptRepository class whenever the
         * StudentReceiptRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            StudentReceiptRepositoryInterface::class,
            StudentReceiptRepository::class,
        );

        /**
         * Binds the ProcessingFeeRepositoryInterface contract to the ProcessingFeeRepository implementation.
         * This allows the application to use the ProcessingFeeRepository class whenever the
         * ProcessingFeeRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            ProcessingFeeRepositoryInterface::class,
            ProcessingFeeRepository::class,
        );

        /**
         * Binds the PaymentStudentRepositoryInterface contract to the PaymentStudentRepository implementation.
         * This allows the application to use the PaymentStudentRepository class whenever the
         * PaymentStudentRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            PaymentStudentRepositoryInterface::class,
            PaymentStudentRepository::class,
        );

        /**
         * Binds the StudentAttendanceRepositoryInterface contract to the StudentAttendanceRepository implementation.
         * This allows the application to use the StudentAttendanceRepository class whenever the
         * StudentAttendanceRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            StudentAttendanceRepositoryInterface::class,
            StudentAttendanceRepository::class,
        );

        /**
         * Binds the SubjectRepositoryInterface contract to the SubjectRepository implementation.
         * This allows the application to use the SubjectRepository class whenever the
         * SubjectRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            SubjectRepositoryInterface::class,
            SubjectRepository::class,
        );

        /**
         * Binds the ExamRepositoryInterface contract to the ExamRepository implementation.
         * This allows the application to use the ExamRepository class whenever the
         * ExamRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            ExamRepositoryInterface::class,
            ExamRepository::class,
        );

        /**
         * Binds the QuizzeRepositoryInterface contract to the QuizzeRepository implementation.
         * This allows the application to use the QuizzeRepository class whenever the
         * QuizzeRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            QuizzeRepositoryInterface::class,
            QuizzeRepository::class,
        );

        /**
         * Binds the QuestionRepositoryInterface contract to the QuestionRepository implementation.
         * This allows the application to use the QuestionRepository class whenever the
         * QuestionRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            QuestionRepositoryInterface::class,
            QuestionRepository::class,
        );

        /**
         * Binds the LibraryRepositoryInterface contract to the LibraryRepository implementation.
         * This allows the application to use the LibraryRepository class whenever the
         * LibraryRepositoryInterface is requested, enabling dependency injection and
         * loose coupling.
         */
        $this->app->bind(
            LibraryRepositoryInterface::class,
            LibraryRepository::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
