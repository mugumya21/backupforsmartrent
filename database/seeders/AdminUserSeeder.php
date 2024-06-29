<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HR\Employee;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
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


        $admin_permission = Permission::firstOrCreate(['name' => 'admin']);
        $reports_permission = Permission::firstOrCreate(['name' => 'reports']);
        $approve_requisition_permission = Permission::firstOrCreate(['name' => 'approve_requisition']);
        $pay_out_requisition_permission = Permission::firstOrCreate(['name' => 'pay_out_requisition']);
        $approve_invoice_permission = Permission::firstOrCreate(['name' => 'approve_invoice']);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $adminRole->syncPermissions([$admin_permission]);

        Role::firstOrCreate(['name' => 'property_manager'],
        ['guard_name' => 'web', 'description' => 'property_manager',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]
    );

    Role::firstOrCreate(['name' => 'landlord'],
        ['guard_name' => 'web', 'description' => 'landlord',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]
    );


    Role::firstOrCreate(['name' => 'supervisor'],
        ['guard_name' => 'web', 'description' => 'supervisor',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]
    );


    Role::firstOrCreate(['name' => 'cashier'],
        ['guard_name' => 'web', 'description' => 'cashier',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()]
    );

        $systemUser = User::firstOrCreate(['email' => 'system@smartcase.co.ug'],
            [
                'name' => 'system@smartcase.co.ug',
                'password' => '!D0m-Art',
                'is_active' => false,
            ]
        );

        Employee::firstOrCreate(['user_id' => $systemUser->id],
            [
                'first_name' => 'System',
                'middle_name' => '',
                'last_name' => 'System',
                'telephone' => '00000000',
                'date_of_birth' => Carbon::create(1986, 1, 31, 0),
                'gender' => 1,
                'user_id' => $systemUser->id,
                'created_by' => $systemUser->id,
                'created_at' => Carbon::now()
            ]);

        $user = User::firstOrCreate(['email' => 'admin@example.com'],
            ['name' => 'admin@example.com',
            'password' => '!D0m-Art',
            'is_active' => true ]
        );

        Employee::firstOrCreate(['user_id' => $user->id],
            [
            'first_name' => 'John',
            'middle_name' => '',
            'last_name' => 'Doe',
            'telephone' => '09875678',
            'date_of_birth' => Carbon::create(1986, 1, 31, 0),
            'gender' => 1,
            'user_id' => $user->id,
            'created_by' => $systemUser->id,
            'created_at' => Carbon::now()
        ]);

        $user->syncRoles([$adminRole]);
    }

}
