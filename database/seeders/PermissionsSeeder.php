<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            Permission::firstOrCreate(['name' => 'sysadmin'],
            ['guard_name' => 'web', 
                'created_at' => Carbon::now(),'updated_at' => Carbon::now()
            ]
        );

        Permission::firstOrCreate(['name' => 'create_property'],
            ['guard_name' => 'web', 
                'created_at' => Carbon::now(),'updated_at' => Carbon::now()
       ]
        );

        Permission::firstOrCreate(['name' => 'edit_property'],
            ['guard_name' => 'web', 
                'created_at' => Carbon::now(),'updated_at' => Carbon::now()
              ]
        );

        Permission::firstOrCreate(['name' => 'view_property'],
            ['guard_name' => 'web', 
                'created_at' => Carbon::now(),'updated_at' => Carbon::now()
              ]
        );

        Permission::firstOrCreate(['name' => 'list_property'],
            ['guard_name' => 'web', 
                'created_at' => Carbon::now(),'updated_at' => Carbon::now()
                ]
        );

        Permission::firstOrCreate(['name' => 'delete_property'],
            ['guard_name' => 'web', 
                'created_at' => Carbon::now(),'updated_at' => Carbon::now()
                ]
        );

        Permission::firstOrCreate(['name' => 'create_floors'],
        ['guard_name' => 'web', 
            'created_at' => Carbon::now(),'updated_at' => Carbon::now()
            ]
    );

    Permission::firstOrCreate(['name' => 'edit_floors'],
        ['guard_name' => 'web', 
            'created_at' => Carbon::now(),'updated_at' => Carbon::now()
            ]
    );

    Permission::firstOrCreate(['name' => 'view_floors'],
        ['guard_name' => 'web', 
            'created_at' => Carbon::now(),'updated_at' => Carbon::now()
            ]
    );

    Permission::firstOrCreate(['name' => 'list_floors'],
        ['guard_name' => 'web', 
            'created_at' => Carbon::now(),'updated_at' => Carbon::now()
            ]
    );

    Permission::firstOrCreate(['name' => 'delete_floors'],
        ['guard_name' => 'web', 
            'created_at' => Carbon::now(),'updated_at' => Carbon::now()
            ]
    );

    Permission::firstOrCreate(['name' => 'create_units'],
    ['guard_name' => 'web', 
        'created_at' => Carbon::now(),'updated_at' => Carbon::now()
        ]
);

Permission::firstOrCreate(['name' => 'edit_units'],
    ['guard_name' => 'web', 
        'created_at' => Carbon::now(),'updated_at' => Carbon::now()
        ]
);

Permission::firstOrCreate(['name' => 'view_units'],
    ['guard_name' => 'web', 
        'created_at' => Carbon::now(),'updated_at' => Carbon::now()
        ]
);

Permission::firstOrCreate(['name' => 'list_units'],
    ['guard_name' => 'web', 
        'created_at' => Carbon::now(),'updated_at' => Carbon::now()
        ]
);

Permission::firstOrCreate(['name' => 'delete_units'],
    ['guard_name' => 'web', 
        'created_at' => Carbon::now(),'updated_at' => Carbon::now()
        ]
);

Permission::firstOrCreate(['name' => 'create_tenantunit'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'edit_tenantunit'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'view_tenantunit'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'list_tenantunit'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'delete_tenantunit'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'create_payments'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'edit_payments'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'view_payments'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'list_payments'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'delete_payments'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'create_documents'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'edit_documents'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'view_documents'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'list_documents'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'delete_documents'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'view_reports'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'print_reports'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'create_expenses'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'edit_expenses'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'view_expenses'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'list_expenses'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'delete_expenses'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'create_clients'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'edit_clients'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'view_clients'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'list_clients'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'delete_clients'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'create_invoice'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'edit_invoice'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'view_invoice'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'list_invoice'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'delete_invoice'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'approve_invoice'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);

Permission::firstOrCreate(['name' => 'approve_expenses'],
['guard_name' => 'web', 
    'created_at' => Carbon::now(),'updated_at' => Carbon::now()
    ]
);


      
    }
}
