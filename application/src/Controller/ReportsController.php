<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use App\Repository\TransactionsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReportsController extends AbstractController
{
    #[Route('/reports', name: 'reports')]
    public function index(RequestStack $requestStack, Request $request, 
            TransactionsRepository $transactionsRepository, 
            ProductsRepository $productsRepository
        ): Response
    {
        $params = [
            "from_date" => $request -> get('trans_date_from'),
            "to_date" => $request -> get('trans_date_to'),
            "type" => $request -> get('trans_type'),
            "product" => $request -> get('trans_product'),
            "compared" => $request -> get('trans_comp'),
            "csv" => $request -> get('trans_csv'),
        ];
        $reports = $transactionsRepository -> getReport($params);
        $reportsPrev = [];
        if($params['compared']){
            $prevDate = (new DateTime()) -> modify("-".$params["compared"]." month");
            $lastMonth = (new DateTime()) -> modify("-1 month");
            $params["from_date"] = $prevDate -> format("Y-m-01");
            $params["to_date"] = $lastMonth -> format("Y-m-t 23:59:59");
            $reportsPrev = $transactionsRepository -> getReport($params);
            $reports = $this -> bindReports($reports, $reportsPrev);
        }
        $products = $productsRepository -> findAllArr();
        $params['type_text'] = $params['type'] == 0 ? 'Pending' : ($params['type'] == 1 ? 'Finished' : '');
        $params['product_text'] = "";
        if($params['product']){
            $params['product_text'] = array_values(array_filter(
                    array_map(fn($item) => $item['id'] == $params['product'] ? $item['name'] : '', $products)
            ))[0];
        }

        if($params["csv"]){
            $response = $this->render('reports/export.csv.twig',['reports' => $reports, 'params' => $params]);
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="report_export.csv"');
            return $response;
        }

        return $this->render('reports/index.html.twig', array_merge([
            'controller_name' => 'ReportsController',
            'products' => $products,
            'reports' => $reports,
            'reports_prev' => $reportsPrev,
            'params' => $params,
        ], $requestStack -> getSession() -> get("menuOptions")));
    }

    public function bindReports($reportsA, $reportsB) : array{
        $result = [];
        foreach ($reportsA as $report){
            $report["compared"] = array_values(array_filter(
                array_map(fn($item) => ($item['name'] == $report['name'] && $item['status'] == $report['status']) ? $item['tsnr'] : '', $reportsB)
            ))[0] ?? 0;
            $result[] = $report;
        }
        return $result;
    }
}

