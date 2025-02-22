<?php

namespace App\DataTables;

use App\Models\Backup;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BackupDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $editRoute = route('backup.update', $item->uuid);
                $deleteRoute = route('backup.destroy', $item->uuid);
                $actionButton = "<div class='dropdown'>
                                <button class='btn btn-tabler btn-icon' data-bs-toggle='dropdown' aria-label='Tabler'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-settings'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                        <path d='M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z'/>
                                        <path d='M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0'/>
                                    </svg>
                                </button>

                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#editModal' data-url='{$editRoute}' data-project_id='{$item->project_id}' data-user_id='{$item->user_id}' data-description='{$item->description}'>
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
                $actionButton = "<button class='btn btn-warning btn-icon' data-bs-toggle='modal' data-bs-target='#backupModal' data-url='{$fileUrl}'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-file-type-sql'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                        <path d='M14 3v4a1 1 0 0 0 1 1h4'/>
                                        <path d='M14 3v4a1 1 0 0 0 1 1h4'/>
                                        <path d='M5 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75'/>
                                        <path d='M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4'/>
                                        <path d='M18 15v6h2'/>
                                        <path d='M13 15a2 2 0 0 1 2 2v2a2 2 0 1 1 -4 0v-2a2 2 0 0 1 2 -2z'/>
                                        <path d='M14 20l1.5 1.5'/>
                                    </svg>
                                </button>";

                return $actionButton;
            })
            ->rawColumns(['#', 'file']);
    }

    public function query(Backup $model): QueryBuilder
    {
        return $model->with([
            'project',
            'user',
            ])->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('backup-table')
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
            Column::make('project.name')->title('Project'),
            Column::make('description')->title('Description'),
            Column::computed('file')->title('File Backup'),
            Column::make('user.name')->title('Uploaded By'),
            Column::make('updated_at')->title('Uploaded At'),
        ];
    }

    protected function filename(): string
    {
        return 'Backup_' . date('YmdHis');
    }
}
