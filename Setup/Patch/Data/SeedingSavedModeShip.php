<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace CorreosExpress\RegistroDeEnvios\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class SeedingSavedModeShip 
    implements DataPatchInterface,
    PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;


    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup
    ) {        
        $this->moduleDataSetup  = $moduleDataSetup;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->install_cex_mode_ships_data($this->moduleDataSetup);
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
            \CorreosExpress\RegistroDeEnvios\Setup\Patch\Data\SeedingCustomerOptions::class
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

    public function install_cex_mode_ships_data($setup){
        $tabla= $setup->getTable('correosexpress_registrodeenvios_cexsavedmodeships');

        $modeships = array(
            array(
                    'name'=>'Paq 10',
                    'id_bc' => '61',
                    'id_carrier' => ';cexpaq10;',
                    'checked' => 0,
                    'short_name' => 'PAQ10'
                ),
            array(
                   
                    'name'=>'Paq 14',
                    'id_bc'=>'62',
                    'short_name' => 'PAQ14',
                    'id_carrier' => ';cexpaq14;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Paq 24',
                    'id_bc'=>'63',
                    'short_name' => 'PAQ24',
                    'id_carrier' => ';cexpaq24;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Baleares Express',
                    'id_bc'=>'66',
                    'short_name' => 'BAL',
                    'id_carrier' => ';cexbaleares;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Canarias Express',
                    'id_bc'=>'67',
                    'short_name' => 'CANE',
                    'id_carrier' => ';cexcanarias;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Canarias Aéreo',
                    'id_bc'=>'68',
                    'short_name' => 'CANA',
                    'id_carrier' => ';cexcanariasaereo;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Canarias Marítimo',
                    'id_bc'=>'69',
                    'short_name' => 'CANM',
                    'id_carrier' => ';cexcanariasmaritimo;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Portugal Óptica',
                    'id_bc'=>'73',
                    'short_name' => 'CEXOROPT',
                    'id_carrier' => ';cexportugal;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Paquetería Ópticas',
                    'id_bc'=>'76',
                    'short_name' => 'PQOP',
                    'id_carrier' => ';cexpaqoptica;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Internacional Express',
                    'id_bc'=>'91',
                    'short_name' => 'IEX',
                    'id_carrier' => ';cexpaqinternacional;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Internacional Estándar',
                    'id_bc'=>'90',
                    'short_name' => 'IE',
                    'id_carrier' => ';cexpaqinterestandar;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Paq Empresa 14',
                    'id_bc'=>'92',
                    'short_name' => 'PAQE14',
                    'id_carrier' => ';cexpaqempresa14;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'ePaq24',
                    'id_bc'=>'93',
                    'short_name' => 'ePAQ24',
                    'id_carrier' => ';cexepaq24;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Campaña Cex',
                    'id_bc'=>'27',
                    'short_name' => 'CCEX',
                    'id_carrier' => ';cexcampana;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Entrega en Oficina',
                    'id_bc'=>'44',
                    'short_name' => 'EOFEL',
                    'id_carrier' => ';cexEntregaOficina;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Entrega Plus',
                    'id_bc'=>'54',
                    'short_name' => '54ER',
                    'id_carrier' => ';cexentregamultichrono;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Entrega Plus con manupulación',
                    'id_bc'=>'55',
                    'short_name' => '55ERM',
                    'id_carrier' => ';cexentregamanipmultichrono;',
                    'checked' => 0,
                ),
            array(
                   'name'=>'Islas Express',
                    'id_bc'=>'26',
                    'short_name' => 'ISEXP',
                    'id_carrier' => ';cexislasexpress;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Islas Documentación',
                    'id_bc'=>'46',
                    'short_name' => 'ISDOC',
                    'id_carrier' => ';cexislasdoc;',
                    'checked' => 0,
                ),
            array(
                    'name'=>'Islas Marítimo',
                    'id_bc'=>'79',
                    'short_name' => 'ISEST',
                    'id_carrier' => ';cexislasmaritimo;',
                    'checked' => 0,
                )
        );
     
        foreach ($modeships as $modeship) {
            $setup->getConnection()->insertOnDuplicate($tabla, $modeship);
        }

        $migration = '04 - SEEDING cexsavedmodeships';
        $this->registrar_ejecucion_migracion($migration, $setup);
    }

    public function registrar_ejecucion_migracion($nombre_migracion, $setup){

        $tableMigrations =$setup->getTable('correosexpress_registrodeenvios_cexmigrations');

        $migration = array(
            'metodo_ejecutado' => $nombre_migracion,
        );

        $setup->getConnection()->insertOnDuplicate($tableMigrations,$migration);
    }
}
