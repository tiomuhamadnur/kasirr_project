<?php

namespace App\DataTables;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AssetDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('asset.update', $item->uuid);
                $deleteRoute = route('asset.destroy', $item->uuid);
                $fileUrl = asset('/storage/' . $item->file);
                $actionButton = "<div class='dropdown'>
                                <button class='btn btn-tabler btn-icon' data-bs-toggle='dropdown' aria-label='Tabler'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-settings'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                        <path d='M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z'/>
                                        <path d='M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0'/>
                                    </svg>
                                </button>

                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal' data-url='{$editRoute}' data-title='{$item->title}' data-description='{$item->description}' data-type='{$item->type}' data-status='{$item->status}' data-file_url='{$fileUrl}'>
                                        <svg  xmlns='http://www.w3.org/2000/svg'  width='24'  height='24'  viewBox='0 0 24 24'  fill='none'  stroke='currentColor'  stroke-width='2'  stroke-linecap='round'  stroke-linejoin='round'  class='icon icon-tabler icons-tabler-outline icon-tabler-pencil'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4' /><path d='M13.5 6.5l4 4' /></svg>
                                        Edit
                                    </a>
                                    <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#deleteModal' data-url='{$deleteRoute}'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-trash'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                        <path d='M4 7l16 0' />
                                        <path d='M10 11l0 6' />
                                        <path d='M14 11l0 6' />
                                        <path d='M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12' />
                                        <path d='M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3' />
                                        </svg>
                                        Delete
                                    </a>
                                </div>
                            </div>";

                return $actionButton;
            })
            ->addColumn('file', function ($item) {
                $fileUrl = asset('/storage/' . $item->file);
                $actionButton = "<button class='btn btn-warning btn-icon' data-bs-toggle='modal' data-bs-target='#fileModal' data-url='{$fileUrl}'>
                                    <svg  xmlns='http://www.w3.org/2000/svg'  width='24'  height='24'  viewBox='0 0 24 24'  fill='none'  stroke='currentColor'  stroke-width='2'  stroke-linecap='round'  stroke-linejoin='round'  class='icon icon-tabler icons-tabler-outline icon-tabler-file'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                        <path d='M14 3v4a1 1 0 0 0 1 1h4' />
                                        <path d='M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z' />
                                    </svg>
                                </button>";

                return $actionButton;
            })
            ->rawColumns(['#', 'file']);
    }

    public function query(Asset $model): QueryBuilder
    {
        return $model->with([
            'user',
            ])->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('asset-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    //->dom('Bfrtip')
                    ->orderBy([0, 'asc'])
                    ->selectStyleSingle()
                    ->buttons([
                        [
                            'extend' => 'excel',
                            'text' => 'Export to Excel',
                            'attr' => [
                                'id' => 'datatable-excel',
                                'style' => 'display: none;',
                            ],
                        ],
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('#')->exportable(false)->printable(false)->width(60)->addClass('text-center'),
            Column::make('title')->title('Title'),
            Column::make('description')->title('Description'),
            Column::make('type')->title('Type'),
            Column::computed('file')->title('File'),
            Column::make('status')->title('Status'),
            Column::make('user.name')->title('Updated By'),
            Column::make('updated_at')->title('Updated At'),
        ];
    }

    protected function filename(): string
    {
        return 'Asset_' . date('YmdHis');
    }
}
