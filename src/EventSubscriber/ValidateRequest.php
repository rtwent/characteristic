<?php


namespace App\EventSubscriber;


use App\Exceptions\InvalidArgument;
use App\Exceptions\RequestValidation;
use App\Exceptions\WrongRequest;
use App\Interfaces\ValidatableRequest;
use App\Services\ValidationServices\Characteristics\CharacteristicCreate;
use App\Services\ValidationServices\MeasurementUnits\MeasurementUnitsCreate;
use App\Services\ValidationServices\RepresentationValues\RepresentationValuesCreate;
use App\Services\ValidationServices\RepresentationValues\RepresentationValuesUpdate;
use App\Services\ValidationServices\Values\ValuesCreate;
use ReflectionException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
            'validatorArguments' => ['entityManager'],
        ],
        'v1_characteristics_update' => [
            'class' => CharacteristicCreate::class,
            'validatorArguments' => ['entityManager']
        ],
        'v1_values_create' => [
            'class' => ValuesCreate::class,
            'validatorArguments' => ['entityManager']
        ],
        'v1_representation_values_insert' => [
            'class' => RepresentationValuesCreate::class,
            'validatorArguments' => ['entityManager', 'request']
        ],
        'v1_representation_values_update' => [
            'class' => RepresentationValuesCreate::class,
            'validatorArguments' => ['entityManager', 'request']
        ],
        'v1_units_create' => [
            'class' => MeasurementUnitsCreate::class,
            'validatorArguments' => ['entityManager']
        ],
        'v1_units_update' => [
            'class' => MeasurementUnitsCreate::class,
            'validatorArguments' => ['entityManager']
        ],

        // injecting entity manager example (beta version made by hand in self::onArgumentsCheck())
//        'v1_values_update' => [
//            'class' => ValuesCreate::class,
//            'validatorArguments' => ['entityManager']
//        ],
    ];

    private array $initializedArguments = ['entityManager'];

    private EntityManagerInterface $entityManager;
    private RequestStack $request;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $request)
    {
        $this->initializedArguments['entityManager'] = $entityManager;
        $this->initializedArguments['request'] = $request;
    }

    /**
     * @inheritDoc
     * @return array|string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER_ARGUMENTS => ['onArgumentsCheck', 12],
        ];
    }

    /**
     * @param ControllerArgumentsEvent $event
     * @throws ReflectionException
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
        //$validatorArguments['request'] = $this->initializedArguments['request'];
        $validator = $r->newInstanceArgs($validatorArguments);

        if ($request->isMethod(Request::METHOD_GET)) {
            $requestData = $request->query->all();
        } else {
            $requestData = $request->request->all();
        }

        $errors = $validator->validate($requestData);

        if (count($errors) > 0) {
            throw new WrongRequest(implode(", ", $errors), null, [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

}