<?php

namespace App\Services;

// ИНСТРУМЕНТЫ, КОТОРЫЕ НАМ НУЖНЫ:
use Illuminate\Support\Facades\Http;
// 1. "Браузер" (сходить по URL)
use Symfony\Component\DomCrawler\Crawler;
// 2. "Скальпель" (покопаться в HTML)
use Exception;

// 3. "Ловушка" для ошибок

class CrawlService
{
    /**
     * Конструктор (нам не нужен, так как методы статические)
     */
    public function __construct()
    {
        //
    }

    /**
     * "Научим" стажера ходить по URL и тащить теги (например, h1)
     */
    public static function getHTags(string $url, string $tag): ?string
    {
        try {
            // 1. "Сходить" по URL и "скачать" HTML-страницу
            // "ПОЧИНЕННЫЙ" ВЫЗОВ
            $response = Http::withoutVerifying()->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36'
            ])->get($url);

            // "ШПИОН" (сразу ПОСЛЕ вызова)
            // 2. Если страница не найдена или сломана, уходим
            if (!$response->successful()) {
                return null; // Возвращаем "ничего"
            }

            // 3. "Скормить" скачанный HTML (простыню) "Скальпелю"
            $crawler = new Crawler($response->body());

            // 4. "Сказать скальпелю": Найди мне ПЕРВЫЙ тег (который ты попросил, $tag)
            //    и верни его ТЕКСТ.
            $foundTag = $crawler->filter($tag)->first();
            $foundCount = $foundTag->count();
            \Log::info("ШПИОН ДЛЯ H1: 'Скальпель' нашел $foundCount тегов '$tag'.");

            // 5. Если мы что-то нашли, возвращаем текст. Если нет - null.
            return $foundTag->count() > 0 ? $foundTag->text() : null;
        } catch (Exception $e) {
            // Если "авария" (URL не открылся, таймаут), просто возвращаем "ничего"
            // Мы запишем ошибку в лог, чтобы ты знал, что пошло не так
            report($e);
            return null;
        }
    }

    /**
     * "Научим" стажера тащить meta-description
     */
    public static function getMetaDescription(string $url): ?string
    {
        try {
            // 1. "Сходить" по URL и "скачать" HTML
            // "ПОЧИНЕННЫЙ" ВЫЗОВ
            $response = Http::withoutVerifying()->withHeaders([
             'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36'
            ])->get($url);

            // "ШПИОН" (сразу ПОСЛЕ вызова)
            // 2. Если страница не найдена, уходим
            if (!$response->successful()) {
                return null;
            }

            // 3. "Скормить" HTML "Скальпелю"
            $crawler = new Crawler($response->body());

            // 4. "Сказать скальпелю": Найди мне тег <meta>
            //    у которого атрибут [name='description']
            $metaTag = $crawler->filter("meta[name='description']")->first();
            $foundCount = $metaTag->count();
            \Log::info("ШПИОН ДЛЯ META: 'Скальпель' нашел $foundCount meta-тегов.");
            // 5. Если нашли, "попросить" у него АТРИБУТ 'content'
            return $metaTag->count() > 0 ? $metaTag->attr('content') : null;
        } catch (Exception $e) {
            // Если "авария", возвращаем "ничего"
            report($e);
            return null;
        }
    }
    public static function crawl(string $url): void
    {
        //
    }
}
