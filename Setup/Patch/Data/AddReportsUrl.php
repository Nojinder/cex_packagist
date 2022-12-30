<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace CorreosExpress\RegistroDeEnvios\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddReportsUrl 
    implements DataPatchInterface,
    PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    private $_cexSavedmodeshipFactory;



    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        \CorreosExpress\RegistroDeEnvios\Model\CexSavedmodeshipFactory $cexSavedmodeshipFactory
    ) {        
        $this->moduleDataSetup  = $moduleDataSetup;
        $this->_cexSavedmodeshipFactory = $cexSavedmodeshipFactory;

    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->add_reports_url($this->moduleDataSetup);
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        /**
         * This is dependency to another patch. Dependency should be applied first
         * One patch can have few dependencies
         * Patches do not have versions, so if in old approach with Install/Ugrade data scripts you used
         * versions, right now you need to point from patch with higher version to patch with lower version
         * But please, note, that some of your patches can be independent and can be installed in any sequence
         * So use dependencies only if this important for you
         */
        return [
            \CorreosExpress\RegistroDeEnvios\Setup\Patch\Data\FixSavedModeShip::class
        ];
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        //Here should go code that will revert all operations from `apply` method
        //Please note, that some operations, like removing data from column, that is in role of foreign key reference
        //is dangerous, because it can trigger ON DELETE statement
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        /**
         * This internal Magento method, that means that some patches with time can change their names,
         * but changing name should not affect installation process, that's why if we will change name of the patch
         * we will add alias here
         */
        return [];
    }

    public function add_reports_url($setup){
         $migration_name= '05 - Add MXPS_REPORTWS 4.1.0';
        $tableResource = $setup->getTable("correosexpress_registrodeenvios_cexcustomeroptions");
        if ($setup->getConnection()->isTableExists($tableResource) == true) {
            $customeroptions = array(                
                array(
                    'clave' => 'MXPS_REPORTWS',
                    'valor' => 'http://ws.desa.int.k8s.correosexpress.com/wspsc/apiRestGeneracionInformes/json/generarInforme'
                )
            );

            foreach ($customeroptions as $customeroption) {
                $setup->getConnection()->insertOnDuplicate($tableResource, $customeroption);
            }
            $this->registrar_ejecucion_migracion($migration_name, $setup);
        }
    }

    public function registrar_ejecucion_migracion($nombre_migracion, $setup){

        $tableMigrations =$setup->getTable('correosexpress_registrodeenvios_cexmigrations');

        $migration = array(
            'metodo_ejecutado' => $nombre_migracion,
        );

        $setup->getConnection()->insertOnDuplicate($tableMigrations,$migration);
    }
}
