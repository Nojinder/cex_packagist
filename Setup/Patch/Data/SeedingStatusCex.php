<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace CorreosExpress\RegistroDeEnvios\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Sales\Model\Order\StatusFactory;
use Magento\Sales\Model\ResourceModel\Order\StatusFactory as StatusResourceFactory;


class SeedingStatusCex 
    implements DataPatchInterface,
    PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    private $statusFactory;
    private $statusResourceFactory;


    /**
     * @param ModuleDataSetupInterface    $moduleDataSetup
     * @param StatusFactory               $statusFactory
     * @param StatusResourceFactory       $statusResourceFactory
     */

    public function __construct(
        ModuleDataSetupInterface    $moduleDataSetup,
        StatusFactory               $statusFactory,
        StatusResourceFactory       $statusResourceFactory
    ) {        
        $this->moduleDataSetup  = $moduleDataSetup;
        $this->statusFactory = $statusFactory;
        $this->statusResourceFactory = $statusResourceFactory;

    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();        
        $this->registrarEjecucionMigracion('01 - Main Schema Install', $this->moduleDataSetup);
        $this->installCexStatusData($this->moduleDataSetup);
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
        return [];
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->dropCexTables($this->moduleDataSetup);
        $this->deleteModuleVersion($this->moduleDataSetup);
        $this->deleteCarriers($this->moduleDataSetup);
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

    private function installCexStatusData($setup){
        $estados       = [
            ['status'=>'en_curso_cex',  'label'=>'En curso CEX','state'=>'en_curso_cex'],
            ['status'=>'anulado_cex', 'label'=>'Anulado CEX','state'=>'anulado_cex'],
            ['status'=>'devuelto_cex',  'label'=>'Devuelto CEX','state'=>'devuelto_cex'],
            ['status'=>'entregado_cex', 'label'=>'Entregado CEX','state'=>'entregado_cex']
        ];
        foreach ($estados as $estado) {            
            $statusResource = $this->statusResourceFactory->create();            
            $status = $this->statusFactory->create();
            $status->setData([
                'status' => $estado['status'],
                'label' => $estado['label']
            ]);

            try {
                $statusResource->save($status);
                $status->assignState($estado['state'], true, true);
            } catch (AlreadyExistsException $exception) {
                    // log some thing here...
            } catch(Exception $e) {
                    // log some thing here...
            }            
        }


        $migration = '02 - SEEDING statuscex';

        $this->registrarEjecucionMigracion($migration, $setup);
    }

    private function dropCexTables($setup){
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexrespuestacron'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexenvioscron'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexsavedships'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexsavedsenders'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexsavedmodeships'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexhistory'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexenviobultos'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexofficedeliverycorreo'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexcustomeroptions'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexcustomercodes'));   
        $setup->getConnection()->dropTable($setup->getTable('correosexpress_registrodeenvios_cexmigrations')); 
    }

    private function deleteModuleVersion($setup){
        $nombreTabla = $setup->getTable('setup_module');
        $sql = "DELETE FROM $nombreTabla WHERE module='CorreosExpress_RegistroDeEnvios'";
        $setup->getConnection('core_read')->fetchAll($sql);
    }

    private function deleteCarriers($setup){
        $nombreTabla = $setup->getTable('core_config_data');
        $sql = "DELETE FROM $nombreTabla WHERE path LIKE 'carriers/cex%'";
        $setup->getConnection('core_read')->fetchAll($sql);
    }

    private function registrarEjecucionMigracion($nombre_migracion, $setup){

        $tableMigrations =$setup->getTable('correosexpress_registrodeenvios_cexmigrations');

        $migration = array(
            'metodo_ejecutado' => $nombre_migracion,
        );

        $setup->getConnection()->insertOnDuplicate($tableMigrations,$migration);
    }
}
