<?php

namespace App\Db;

class Pagination
{

    /**
     * Numero maximo de registros por pagina
     * @var integer
     */

    private $limit;

    /**Quantidade total de resultados do banco
     * @var integer
     */

    private $results;

    /**
     * Quantidade de paginas
     * @var integer
     */

    private $pages;

    /**
     * Pagina atual
     * @var integer
     */

    private $currentPage;

    /**
     * Construtor da classe
     * @param integer $results
     * @param integer $currentPage
     * @param integer $limit
     */

    public function __construct($results, $currentPage = 1, $limit = 10)
    {
        $this->results = $results;
        $this->limit = $limit;
        $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
        $this->calculate();
    }

    /**
     * Método responsavel por calcular a paginação
     */
    private function calculate()
    {
        //calcula o total de paginas
        $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 0;

        //verifica se a pagina atual não excede o numero de paginas
        $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    /**
     * Método responsavel por retornar a cláusula limit da SQL
     * @return string
     */
    public function getLimit()
    {
        $offset = ($this->limit * ($this->currentPage - 1));

        return $offset . ',' . $this->limit;
    }

    /**
     * Método responsavel por retornar as opções de paginas disponiveis
     * @return array
     */
    public function getPAges()
    {
        //não retorna paginas
        if ($this->pages == 1) return [];

        //paginas
        $paginas = [];
        for ($i = 1; $i <= $this->pages; $i++) {
            $paginas[] = [
                'pagina' => $i,
                'atual' => $i == $this->currentPage
            ];
        }
        return $paginas;
    }
}
