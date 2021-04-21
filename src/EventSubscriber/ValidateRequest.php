<?php


namespace App\EventSubscriber;


use App\Exceptions\RequestValidation;
use App\Interfaces\ValidatableRequest;
use App\Services\ValidationServices\Characteristics\CharacteristicCreate;
use App\Services\ValidationServices\Steps\StoreStepsValidation;
use App\Services\ValidationServices\Customers\CustomerCreate;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use \App\Services\ValidationServices\AbstractServiceValidator;
use Doctrine\ORM\EntityManagerInterface;


class ValidateRequest implements EventSubscriberInterface
{
    /**
     * List of validators depending on route
     * @var array|string[]
     */
    private array $validators = [
        'v1_characteristics_create' => [
            'class' => CharacteristicCreate::class,
            'validatorArguments' => [],
        ],
//        'v1_characteristics_create' => [
//            'class' => CharacteristicCreate::class,
//            'validatorArguments' => ['entityManager']
//        ],
    ];

    private array $initializedArguments = ['entityManager'];

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->initializedArguments['entityManager'] = $entityManager;
    }

    /**
     * @inheritDoc
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => 'onArgumentsCheck',
        ];
    }

    /**
     * @param ControllerArgumentsEvent $event
     * @throws \ReflectionException
     */
    public function onArgumentsCheck(ControllerArgumentsEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if (!$controller instanceof ValidatableRequest) {
            return;
        }

        $request = $event->getRequest();
        $route = $request->get('_route');

        if (!isset($this->validators[$route])) {
            return;
        }

        /** @var $validator AbstractServiceValidator */
        $r = new \ReflectionClass($this->validators[$route]['class']);
        $validatorArguments = [];

        foreach ($this->validators[$route]['validatorArguments'] as $argument) {
            $validatorArguments[] = $this->initializedArguments[$argument];
        }
        //$validatorArguments['entityManager'] = $this->initializedArguments['entityManager'];
        $validator = $r->newInstanceArgs($validatorArguments);

        if ($request->isMethod(Request::METHOD_GET)) {
            $requestData = $request->query->all();
        } else {
            $requestData = $request->request->all();
        }

        $errors = $validator->validate($requestData);
        if (count($errors) > 0) {
            throw new RequestValidation(implode(", ", $errors), null, [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

}