<?php
declare(strict_types=1);

/**
 * Граф слов, где дочерними вершинами каждого слова являются слова, отличные от него на одну букву.
 *
 * @author Игорь Водка
 */
class WordGraph
{
    /**
     * Представление графа слов в виде ассоциативного массива.
     *
     * @var array $graph
     */
    private $graph;

    /**
     * Конструктор класса.
     *
     * @param array $graph
     */
    public function __construct(array $graph)
    {
        $this->graph = $graph;
    }

    /**
     * Возвращает список слов, отличных от выбранного на одну букву.
     *
     * @param string $word
     * @return mixed
     */
    public function getSimilarWords(string $word): array
    {
        return $this->graph[$word];
    }

    /**
     * Возвращает представление графа слов в виде ассоциативного массива.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->graph;
    }
}
