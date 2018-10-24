<?php
declare(strict_types=1);

/**
 * Класс, выполняющий поиск кратчайшего пути между словами, где каждое слово отличается на одну букву.
 *
 * @author Игорь Водка
 */
class WordPathFinder
{
    /**
     * Возвращает кратчайший путь между словами, где каждое слово отличается на одну букву.
     * Возвращает `null`, если такого пути не существует.
     *
     * @details Используется поиск в ширину.
     *
     * @param WordGraph $graph
     * @param string $begin
     * @param string $end
     * @return array|null
     */
    public function findPath(WordGraph $graph, string $begin, string $end): ?array
    {
        $queue = new SplQueue();
        $queue->enqueue([$begin]);
        $visited = [$begin];

        while (!$queue->isEmpty()) {
            $wordPath = $queue->dequeue();

            $word = $wordPath[count($wordPath) - 1];
            if ($word === $end) { // достигли нужного слова
                return $wordPath;
            }

            foreach ($graph->getSimilarWords($word) as $similarWord) {
                if (!in_array($similarWord, $visited)) {
                    $visited[] = $similarWord;

                    $newWordPath = $wordPath;
                    $newWordPath[] = $similarWord;
                    $queue->enqueue($newWordPath);
                }
            }
        }

        return null;
    }
}
