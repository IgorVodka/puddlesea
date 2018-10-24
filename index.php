<?php
/**
 * Тестовое задание для Velvica.
 *
 * @details Здесь решено просто использовать чистый PHP и просто `require`. Всякие автолоадеры, на мой взгляд,
 * лишний оверхед в задаче такого размера.
 *
 * @author Игорь Водка
 */
require('WordGraphCreator.php');
require('WordGraph.php');
require('WordPathFinder.php');
require('WordGraphCache.php');

/**
 * Здесь задаются слова, между которыми происходит поиск пути.
 */
$firstWord = 'лужа';
$lastWord = 'море';
$wordLength = \mb_strlen($firstWord);

/**
 * Пути для файла словаря и файла кэшированного графа соответственно.
 */
$dictFile = 'dict.txt';
$graphFile = "graph{$wordLength}.txt";

/**
 * Здесь создаётся граф. Он либо загружается из кэша (файл `graphFile`), либо создаётся из
 * файла словаря (`dictFile`) и записывается в файл кэша.
 */
$cache = new WordGraphCache();
$graph = $cache->load($graphFile, function () use ($dictFile, $wordLength) {
    echo "Кэш-файл для графа со словами длины {$wordLength} не найден, подождите...\n";
    $graphCreator = new WordGraphCreator();
    return $graphCreator->createGraphFromFile(
        $dictFile,
        function (string $word) use ($wordLength) {
            return \mb_strlen($word) === $wordLength;
        }
    );
});

/**
 * Непосредственно поиск.
 */
$finder = new WordPathFinder();
$path = $finder->findPath($graph, $firstWord, $lastWord);

if ($path === null) {
    echo 'Путь не найден.';
} else {
    echo implode("\n", $path);
}