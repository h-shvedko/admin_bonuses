<?php
return array(
	'modules'=>array(
        'admin' => array(
            'modules' => array(
                'bonuses' => array(
					'import' => array(
						'application.modules.admin.modules.roles.models.*',
						'application.modules.admin.modules.register.models.*',
                                            'application.modules.office.models.*',
                                            'application.modules.admin.modules.warehouse.models.*',
											 'application.modules.register.models.*',
					),				
				)
            ),
			 
        ),
	),
	'urlrules' => array(
					'BonusesCharge' => 'modules/admin/modules/bonuses/commands'
				),

);