<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BooksExport implements FromCollection, WithHeadings, FromArray, ShouldAutoSize
{

    public function array(): array
    {
        return Book::getDataBook();
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul',
            'Penulis',
            'Tahun',
            'Penerbit',
        ];
    }

    public function collection()
    {
        return Book::all();
    }
}
