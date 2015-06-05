<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../view',
    'twig.options' => ['strict_variables' => false]
));

/**
 * Homepage
 */
$app->get('/', function () use ($app) {
    return $app['twig']->render('form.twig');
});

/**
 * Results page
 */
$app->post('/results', function (Request $request) use ($app) {
    $validator = new Validator($request->request);

    if ($validator->isValid()) {
        $val = iterator_to_array($validator->getValues());
        $calc = new ReturnOnInvestmentCalculator(
            $val['number_employees'],
            $val['cost_per_employee'],
            $val['attrition_rate'],
            $val['fee_earners'],
            $val['size_of_hr_dept']
        );

        return $app['twig']->render('results.twig', ['calc' => $calc]);
    }

    return $app['twig']->render('form.twig', ['valid' => false, 'input' => iterator_to_array($validator->getValues())]);
});

$app->run();
