<?php

namespace App\UseCase;

use App\Models\Book;

class BookUseCase
{
    public function __construct() {}

    public function getPrice(array $ids)
    {
        $price = 0;

        if (count($ids) === 0) {
            // 空の配列の場合はnullを渡す;
            // ！！配列としてforeachで回すのでNG！！
            $price = $this->calculateSum(null);
        } else {
            $price = $this->calculateSum($ids);
        }
        // ！！return文書き忘れ！！
    }

    private function calculateSum($ids)
    {
        if (is_null($ids)) return 0;

        $sum = 0;

        foreach ($ids as $id) {

            $price = $this->getBookPrice($id);

            // ！！引数の順序誤り！！
            $taxedPrice = $this->getTaxedPrice(function ($price) {
                return $price * 1.1;
            }, $price);

            $sum += $taxedPrice;
        }
        return $sum;
    }

    private function getBookPrice($id)
    {
        $book = Book::where('id', $id)->get();

        if ($book) {
            return $book->first()->price;
        } else {
            // 対象の本のレコード泣ければブランク返す
            // ！！このメソッドの戻り値は数値として扱わるので空文字はNG！！
            return "";
        }
    }

    private function getTaxedPrice($price, $getTaxedPriceExpression)
    {
        return $getTaxedPriceExpression($price);
    }
}
