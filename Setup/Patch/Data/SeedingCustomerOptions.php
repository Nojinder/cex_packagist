<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace CorreosExpress\RegistroDeEnvios\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class SeedingCustomerOptions
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
        $this->install_cex_customer_options_data($this->moduleDataSetup);
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
            \CorreosExpress\RegistroDeEnvios\Setup\Patch\Data\SeedingStatusCex::class
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

    public function install_cex_customer_options_data($setup){
        $migration_name= '03 - SEEDING cexcustomeroptions';
        $tableResource = $setup->getTable("correosexpress_registrodeenvios_cexcustomeroptions");
        if ($setup->getConnection()->isTableExists($tableResource) == true) {
            $customeroptions = array(
                array(
                    'clave' => 'MXPS_ENABLEOFFICEDELIVERY',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_ORDER_PROCESS_TYPE',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_MSG_DELIVERY_OFFICE',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_CHECK_ENABLESHIPPINGTRACK',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_MSG_ALERT_OFICINACORREOS',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_CLASS_CONTRAREEMBOLSO',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_USER',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_PASSWD',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_WSURL',
                    'valor' => 'https://www.cexpr.es/wspsc/apiRestGrabacionEnviok8s/json/grabacionEnvio/V2'
                ),
                array(
                    'clave' => 'MXPS_WSURLREC',
                    'valor' => 'https://www.correosexpress.com/wpsc/apiRestGrabacionRecogida/json/grabarRecogida'
                ),
                array(
                    'clave' => 'MXPS_WSURLSEG',
                    'valor' => 'https://www.cexpr.es/wspsc/apiRestListaEnvios/json/listaEnvios'
                ),
                array(
                    'clave' => 'MXPS_APIRESTOFI',
                    'valor' => 'https://www.cexpr.es/wspsc/apiRestOficina/v1/oficinas/listadoOficinasCoordenadas'
                ),
                array(
                    'clave' => 'MXPS_WSURLANULREC',
                    'valor' => 'https://www.cexpr.es/wspsc/apiRestGrabacionRecogidaEnviok8s/json/anularRecogida'
                ),
                array(
                    'clave' => 'MXPS_DEFAULTKG',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_ENABLEWEIGHT',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_ENABLESHIPPINGTRACK',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_DEFAULTBUL',
                    'valor' => '1'
                ),
                array(
                    'clave' => 'MXPS_DEFAULTPDF',
                    'valor' => '1'
                ),
                array(
                    'clave' => 'MXPS_DEFAULTSEND',
                    'valor' => ''
                ),
                array(
                    'clave' => 'MXPS_DEFAULTDELIVER',
                    'valor' => 'ENVIO'
                ),
                array(
                    'clave' => 'MXPS_DEFAULTPAYBACK',
                    'valor' => '74'
                ),
                array(
                    'clave' => 'MXPS_TRACKINGCEX',
                    'valor' => 'false'
                ),
                array(
                    'clave' => 'MXPS_CHANGESTATUS',
                    'valor' => 'false'
                ),
                array(
                    'clave' => 'MXPS_RECORDSTATUS',
                    'valor' => '3'
                ),
                array(
                    'clave' => 'MXPS_SENDINGSTATUS',
                    'valor' => '35'
                ),
                array(
                    'clave' => 'MXPS_DELIVEREDSTATUS',
                    'valor' => '38'
                ),
                array(
                    'clave' => 'MXPS_CANCELEDSTATUS',
                    'valor' => '36'
                ),
                array(
                    'clave' => 'MXPS_RETURNEDSTATUS',
                    'valor' => '37'
                ),
                array(
                    'clave' => 'MXPS_SAVEDSTATUS',
                    'valor' => 'true'
                ),
                array(
                    'clave' => 'MXPS_NODATAPROTECTION',
                    'valor' => 'false'
                ),
                array(
                    'clave' => 'MXPS_DATAPROTECTIONVALUE',
                    'valor' => '1'
                ),
                array(
                    'clave' => 'MXPS_CRYPT',
                    'valor' => base64_encode(uniqid(mt_rand()))
                ),
                array(
                    'clave' => 'MXPS_CHECKUPLOADFILE',
                    'valor' => 'false'
                ),
                array(
                    'clave' => 'MXPS_UPLOADFILE',
                    'valor' => 'undefined'
                ),
                array(
                    'clave' => 'MXPS_LABELSENDER',
                    'valor' => 'No Text'
                ),
                array(
                    'clave' => 'MXPS_LABELSENDER_TEXT',
                    'valor' => 'false'
                )
                ,
                array(
                    'clave' => 'MXPS_OBSERVATIONS',
                    'valor' => 'false'
                ),
                array(
                    'clave' => 'MXPS_CRONTYPE',
                    'valor' => 'cron',
                ),
                array(
                    'clave' => 'MXPS_REFETIQUETAS',
                    'valor' => '1',
                ),
                array(
                    'clave' => 'MXPS_TRACKING',
                    'valor' => '1',
                ),
                array(
                    'clave' => 'MXPS_LASTCRONEXE',
                    'valor' => date("Y-m-d H:i:s"),
                ),
                array(
                    'clave' => 'MXPS_CHECK_LOG',
                    'valor' => 'true',
                ),
                array(
                    'clave' => 'MXPS_REPRINTWS',
                    'valor' => 'https://www.cexpr.es/wspsc/apiRestImpresionEtiquetas/json/impresionEtiquetas',
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
