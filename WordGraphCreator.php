<?php
declare(strict_types=1);

/**
 * Класс, выполняющий создание графа слов из файла или массива.
 *
 * @author Игорь Водка
 */
class WordGraphCreator
{
    /**
     * Создаёт граф слов из файла. Вторым аргументом можно передать фильтрующую функцию.
     *
     * @param string $fileName
     * @param callable|null $filter
     * @return WordGraph
     */
    public function createGraphFromFile(string $fileName, ?callable $filter): WordGraph
    {
        $words = $this->loadWordsFromFile($fileName, $filter);
        return $this->createGraphFromWords($words);
    }

    /**
     * Загружает граф слов из файла. Вторым аргументом можно передать фильтрующую функцию.
     *
     * @param string $fileName
     * @param callable|null $filter
     * @return array
     */
    private function loadWordsFromFile(string $fileName, ?callable $filter): array
    {
        $file = fopen($fileName, 'r');
        $words = [];
        while (!feof($file)) {
            $word = trim(fgets($file));
            if ($filter !== null && $filter($word)) {
                $words[] = $word;
            }
        }
        return $words;
    }

    /**
     * Создаёт граф слов из списка слов.
     *
     * @param array $words
     * @return WordGraph
     */
    public function createGraphFromWords(array $words): WordGraph
    {
        $graph = [];
        foreach ($words as $firstWord) {
            foreach ($words as $secondWord) {
                if ($this->stringsHaveOneCharDifference($firstWord, $secondWord)) {
                    $graph[$firstWord][] = $secondWord;
                }
            }
        }
        return new WordGraph($graph);
    }

    /**
     * Возвращает `true`, если две строки отличаются только на один символ, и `false` в обратном случае.
     *
     * @param string $str1
     * @param string $str2
     * @return bool
     */
    private function stringsHaveOneCharDifference(string $str1, string $str2): bool
    {
        $distance = 0;
        if (\mb_strlen($str1) !== \mb_strlen($str2)) {
            return false;
        }
        $len = \mb_strlen($str1);
        for ($i = 0; $i < $len; $i++) {
            if (\mb_substr($str1, $i, 1) !== \mb_substr($str2, $i, 1)) { // символы отличаются?
                $distance++;
                if ($distance > 1) {
                    return false;
                }
            }
        }
        return $distance === 1;
    }
}
