<?php
declare(strict_types=1);

/**
 * Кэш графа слов.
 *
 * @author Игорь Водка
 */
class WordGraphCache
{
    /**
     * Загружает граф слов из файла. Использует переданную функцию для получения графа,
     * если файл не найден или составлен с ошибками, и записывает в таком случае новый файл.
     *
     * @param string $fileName
     * @param callable $graphSupplier
     * @return WordGraph
     */
    public function load(string $fileName, callable $graphSupplier): WordGraph
    {
        $graph = $this->tryLoad($fileName);
        if ($graph === null) {
            /** @var WordGraph $graph */
            $graph = $graphSupplier();
            file_put_contents($fileName, serialize($graph->toArray()));
        }
        return $graph;
    }

    /**
     * Загружает граф слов из файла. Возвращает `null`, если он не найден или составлен с ошибками.
     *
     * @param string $fileName
     * @return null|WordGraph
     */
    private function tryLoad(string $fileName): ?WordGraph
    {
        if (!file_exists($fileName)) {
            return null;
        }
        $graphArray = unserialize(file_get_contents($fileName));
        if ($graphArray === false) {
            return null;
        }
        return new WordGraph($graphArray);
    }
}
