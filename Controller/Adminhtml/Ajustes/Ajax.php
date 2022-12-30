<?php

namespace CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Ajustes;

use CorreosExpress\RegistroDeEnvios\CexCron\CexCron;
use CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Rest;
use CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Helpers;
use Magento\Framework\App\Action\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Model\ResourceModel\Order\Status\Collection;
use Magento\Shipping\Model\Config;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SortOrderBuilder;

//CEX
//interface factory
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterfaceFactory;

//Collection Factory
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedmodeship\CollectionFactory as SavedModesShipsCollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedsender\CollectionFactory as SavedSenderCollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomeroption\CollectionFactory as CustomerOptionCollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomercode\CollectionFactory as CustomerCodeCollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexRespuestaCron\CollectionFactory as RespuestaCronCollectionFactory;

//Repository Interfaces
use CorreosExpress\RegistroDeEnvios\Api\CexSavedmodeshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexSavedsenderRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexCustomeroptionRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexCustomercodeRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexSavedshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexHistoryRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexMigrationRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexEnvioCronRepositoryInterface;

/**
 * Class Ajax
 */
class Ajax extends Action
{
    protected $resultJsonFactory;
    protected $authAdminUserSession;
    protected $formKey;
    protected $setup;
    protected $statusCollection;
    protected $_resource;
    protected $_cexRest;
    protected $_cexHelpers;
    protected $_cexCron;
    protected $scopeConfig;
    protected $shipconfig;
    protected $_fileUploaderFactory;
    protected $_assetRepo;
    protected $cexEnvioCronRepository;
    protected $cexRespuestaCronCollectionFactory;
    protected $sortOrderBuilder;
    protected $configWriter;
    protected $cexSavedmodeshipCollectionFactory;
    protected $cexSavedmodeshipRepository;
    protected $cexSavedsenderFactory;
    protected $cexSavedsenderCollectionFactory;
    protected $cexSavedsenderRepository;
    protected $cexCustomeroptionCollectionFactory;
    protected $cexCustomeroptionRepository;
    protected $cexCustomercodeFactory;
    protected $cexCustomercodeCollectionFactory;
    protected $cexCustomercodeRepository;
    protected $cexSavedshipRepository;
    protected $cexHistoryRepository;
    protected $cexMigrationRepository;
    protected $searchCriteriaBuilder;
    protected $filterBuilder;

    /**
     * Create constructor.
     *
     * @param Context $context
     * @param FormKey $formKey
     * @param JsonFactory $resultJsonFactory
     * @param Session $authSession
     * @param ScopeConfigInterface $scopeConfig
     * @param Config $shipconfig
     * @param UploaderFactory $fileUploaderFactory
     * @param Repository $assetRepo
     * @param ResourceConnection $resource
     * @param Collection $statusCollection
     * @param Rest\Index $cexRest
     * @param Helpers\Index $cexHelpers
     * @param CexCron $cexCron
     * @param CexEnvioCronRepositoryInterface $cexEnviocronRepository
     * @param RespuestaCronCollectionFactory $cexRespuestacronCollectionFactory
     * @param ModuleDataSetupInterface $setup
     * @param WriterInterface $configWriter
     * @param CexSavedmodeshipRepositoryInterface $cexSavedmodeshipRepository
     * @param SavedModesShipsCollectionFactory $cexSavedmodeshipCollectionFactory
     * @param CexSavedsenderInterfaceFactory $cexSavedsenderFactory
     * @param CexSavedsenderRepositoryInterface $cexSavedsenderRepository
     * @param SavedSenderCollectionFactory $cexSavedsenderCollectionFactory
     * @param CexCustomeroptionRepositoryInterface $cexCustomeroptionRepository
     * @param CustomerOptionCollectionFactory $cexCustomeroptionCollectionFactory
     * @param CexCustomercodeInterfaceFactory $cexCustomercodeFactory
     * @param CexCustomercodeRepositoryInterface $cexCustomercodeRepository
     * @param CustomerCodeCollectionFactory $cexCustomercodeCollectionFactory
     * @param CexSavedshipRepositoryInterface $cexSavedshipRepository
     * @param CexHistoryRepositoryInterface $cexHistoryRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param CexMigrationRepositoryInterface $cexMigrationRepository
     */
    public function __construct(
        Context                              $context,
        FormKey                              $formKey,
        JsonFactory                          $resultJsonFactory,
        Session                              $authSession,
        ScopeConfigInterface                 $scopeConfig,
        Config                               $shipconfig,
        UploaderFactory                      $fileUploaderFactory,
        Repository                           $assetRepo,
        ResourceConnection                   $resource,
        Collection                           $statusCollection,
        Rest\Index                           $cexRest,
        Helpers\Index                        $cexHelpers,
        CexCron                              $cexCron,
        CexEnviocronRepositoryInterface      $cexEnviocronRepository,
        RespuestaCronCollectionFactory       $cexRespuestacronCollectionFactory,
        ModuleDataSetupInterface             $setup,
        WriterInterface                      $configWriter,
        CexSavedmodeshipRepositoryInterface  $cexSavedmodeshipRepository,
        SavedModesShipsCollectionFactory     $cexSavedmodeshipCollectionFactory,
        CexSavedsenderInterfaceFactory       $cexSavedsenderFactory,
        CexSavedsenderRepositoryInterface    $cexSavedsenderRepository,
        SavedSenderCollectionFactory         $cexSavedsenderCollectionFactory,
        CexCustomeroptionRepositoryInterface $cexCustomeroptionRepository,
        CustomerOptionCollectionFactory      $cexCustomeroptionCollectionFactory,
        CexCustomercodeInterfaceFactory      $cexCustomercodeFactory,
        CexCustomercodeRepositoryInterface   $cexCustomercodeRepository,
        CustomerCodeCollectionFactory        $cexCustomercodeCollectionFactory,
        CexSavedshipRepositoryInterface      $cexSavedshipRepository,
        CexHistoryRepositoryInterface        $cexHistoryRepository,
        SearchCriteriaBuilder                $searchCriteriaBuilder,
        FilterBuilder                        $filterBuilder,
        SortOrderBuilder                     $sortOrderBuilder,
        CexMigrationRepositoryInterface      $cexMigrationRepository)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->formKey = $formKey;
        $this->setup = $setup;
        $this->statusCollection = $statusCollection;
        $this->authAdminUserSession = $authSession;
        $this->_resource = $resource;
        $this->_cexRest = $cexRest;
        $this->_cexHelpers = $cexHelpers;
        $this->_cexCron = $cexCron;
        $this->shipconfig = $shipconfig;
        $this->scopeConfig = $scopeConfig;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_assetRepo = $assetRepo;
        $this->configWriter = $configWriter;
        $this->cexEnvioCronRepository = $cexEnviocronRepository;
        $this->cexRespuestaCronCollectionFactory = $cexRespuestacronCollectionFactory;
        $this->cexSavedmodeshipRepository = $cexSavedmodeshipRepository;
        $this->cexSavedmodeshipCollectionFactory = $cexSavedmodeshipCollectionFactory;
        $this->cexSavedsenderFactory = $cexSavedsenderFactory;
        $this->cexSavedsenderRepository = $cexSavedsenderRepository;
        $this->cexSavedsenderCollectionFactory = $cexSavedsenderCollectionFactory;
        $this->cexCustomeroptionRepository = $cexCustomeroptionRepository;
        $this->cexCustomeroptionCollectionFactory = $cexCustomeroptionCollectionFactory;
        $this->cexCustomercodeFactory = $cexCustomercodeFactory;
        $this->cexCustomercodeRepository = $cexCustomercodeRepository;
        $this->cexCustomercodeCollectionFactory = $cexCustomercodeCollectionFactory;
        $this->cexSavedshipRepository = $cexSavedshipRepository;
        $this->cexHistoryRepository = $cexHistoryRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->cexMigrationRepository = $cexMigrationRepository;
        parent::__construct($context);
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function getAjaxUrl()
    {
        $this->getUrl('registrodeenvios/ajustes/guardarcodigocliente');
    }

    public function execute()
    {
        $post = $this->getRequest()->getPost();

        if (isset($post['action']) && !empty($post['action'])) {
            $func = $post['action'];
            call_user_func(array($this, $func));
        }
    }

    public function getInitForm()
    {
        $collection = array(
            'codigos' => $this->retornarCodigosCliente(),
            'selectCodCliente' => $this->retornarSelectCodigosCliente(),
            'remitentes' => $this->retornarRemitentes(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
            'productos' => $this->retornarProductos(),
            'selectEstados' => $this->getOrderStatusCore(),
            'selectTransportistas' => $this->retornarTransportistas(),
            'version' => $this->formatearVersionModulo(),
            'unidadMedida' => $this->scopeConfig->getValue('general/locale/weight_unit')
        );
        echo json_encode($collection);
    }

    private function formatearVersionModulo(): string
    {
        $version = $this->_cexHelpers->retornarVersionModulo();
        return '<p class="CEX-text-blue py-3">Versión ' . $version . '</p>';
    }

    public function retornarCodigoCliente()
    {
        $post = $this->getRequest()->getPost();
        $customerCodeId = $post['customer_code_id'];

        $id = intval($customerCodeId);

        $resultsCollection = $this->cexCustomercodeCollectionFactory
            ->create()
            ->getData();

        foreach ($resultsCollection as $itemRespuesta) {
            if ($itemRespuesta['customer_code_id'] == $id) {
                $result = $itemRespuesta;
            }
        }

        echo json_encode($result);

    }

    public function actualizarCodigoCliente()
    {
        $post = $this->getRequest()->getPost();

        $customerCodeId = $post['customer_code_id'];
        $customerCode = $post['customer_code'];
        $codeDemand = 'M' . $customerCode;

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('customer_code_id', $customerCodeId, 'eq')
            ->create();

        $customerCodeModel = $this->cexCustomercodeRepository
            ->getList($searchCriteria)
            ->getItems();

        $customerCodeModel = reset($customerCodeModel);

        if (empty($customerCode)) {
            $comprobante = false;
        } else {

            $customerCodeModel->setCustomerCode($customerCode);
            $customerCodeModel->setCodeDemand($codeDemand);

            $comprobante = $this->cexCustomercodeRepository->save($customerCodeModel);
        }

        if (empty($mensaje)) {
            if ($comprobante) {
                $mensaje = array(
                    'type' => 'success',
                    'title' => __('Actualizar código cliente'),
                    'mensaje' => __('Código de cliente actualizado con exito'),
                );
            } else {
                $mensaje = array(
                    'type' => 'error',
                    'title' => __('Actualizar código cliente'),
                    'mensaje' => __('Código de cliente no válido'),
                );
            }
        }

        $retorno = array(
            'mensaje' => $mensaje,
            'codigos' => $this->retornarCodigosCliente(),
            'selectCodCliente' => $this->retornarSelectCodigosCliente(),
            'remitentes' => $this->retornarRemitentes(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
            'productos' => $this->retornarProductos(),
            'selectTransportistas' => $this->retornarTransportistas()
        );

        echo json_encode($retorno);
    }

    private function retornarCodigosCliente(): ?string
    {
        $cabecera = "";
        $contenido = '';
        $i = 1;

        $resultsCollection = $this->cexCustomercodeCollectionFactory
            ->create()
            ->getData();

        if (sizeof($resultsCollection) == 0) {
            return null;
        }

        $container = '<div class="container-fluid">';
        $cabecera .= '<div class="row-fluid CEX-background-blue CEX-text-white p-1 d-flex align-items-center">
            <div class="col-8 col-sm-8 my-auto">' . __("Código cliente") . '</div>
            <div class="col-4 col-sm-4 d-none my-auto">' . __("Código solicitante") . '</div>
            </div>';
        foreach ($resultsCollection as $result) {

            if ($i % 2 != 0) {
                $clase = 'CEX-background-gris-claro';
            } else {
                $clase = '';
            }

            $contenido .= '<div id="cc' . $result['customer_code_id'] . '" class="row ' . $clase . ' p-3 d-flex align-items-center">
                    <div class="col-6 col-sm-8 my-auto">' . $result['customer_code'] . '</div>
                    <div class="col-6 col-sm-4 d-none my-auto">' . $result['code_demand'] . '</div>
                    <div class="col-6 col-sm-4 my-auto">
                     <a id="' . $result['customer_code_id'] . '" tabindex="" class="CEX-btn CEX-button-blue cex_actualizar_codigo_cliente d-inline-block" onclick="pedirCodigoCliente(this.id);">
                         <i class="fas fa-pencil-alt"></i>
                     </a>
                     <a id="' . $result['customer_code_id'] . '" tabindex="" class="CEX-btn CEX-button-cancel cex_borrar_codigo_cliente d-inline-block" onclick="borrarCodigoCliente(this.id)">
                         <i class="fas fa-times"></i>
                     </a>
                    </div></div>';
            $i++;
        }

        $container .= "</div>";

        return $cabecera . $contenido . $container;
    }

    private function retornarSelectCodigosCliente(): string
    {

        $resultsCollection = $this->cexCustomercodeCollectionFactory
            ->create()
            ->getData();

        if (sizeof($resultsCollection) == 0) {
            $select = " <select id='codigo_cliente' name='codigo_cliente' class='form-control' disabled>
                                <option value=' '>'" . __('No hay códigos de cliente disponibles') . "</option>
                            </select>";
        } else {
            $cabecera = "<select id='codigo_cliente' name='codigo_cliente' class='form-control rounded-right'>";
            $contenido = '';

            foreach ($resultsCollection as $result) {
                $contenido .= " <option value='" . $result['customer_code_id'] . "'>" . $result['customer_code'] . "</option>";
            }

            $footer = "</select>";
            $select = $cabecera . $contenido . $footer;
        }
        return $select;
    }

    public function guardarCodigoCliente()
    {
        $post = $this->getRequest()->getPost();

        if (empty($post['customer_code'])) {
            $comprobante = false;
        } else {
            $customerCode = $this->getRequest()->getPost('customer_code');

            $cexcustomeroptionDTO = $this->cexCustomercodeFactory->create();
            $cexcustomeroptionDTO->setCustomerCode($customerCode);
            $cexcustomeroptionDTO->setCodeDemand('M' . $customerCode);
            $cexcustomeroptionDTO->setIdShop(1);

            if ($this->cexCustomercodeRepository->save($cexcustomeroptionDTO)) {
                $comprobante = true;
            } else {
                $comprobante = false;
                $mensaje = array(
                    'type' => 'error',
                    'title' => __('Actualizar código cliente'),
                    'mensaje' => __('Código de cliente ya existente')
                );
            }
        }
        if (empty($mensaje)) {
            if ($comprobante) {
                $mensaje = array(
                    'type' => 'success',
                    'title' => __('Actualizar código cliente'),
                    'mensaje' => __('Código de cliente actualizado con exito')
                );
            } else {
                $mensaje = array(
                    'type' => 'error',
                    'title' => __('Actualizar código cliente'),
                    'mensaje' => __('Código de cliente no válido'),
                );
            }
        }

        $response = array(
            'mensaje' => $mensaje,
            'codigos' => $this->retornarCodigosCliente(),
            'selectCodCliente' => $this->retornarSelectCodigosCliente(),
            'remitentes' => $this->retornarRemitentes(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
            'productos' => $this->retornarProductos(),
            'selectTransportistas' => $this->retornarTransportistas()
        );
        echo json_encode($response);
    }

    public function borrarCodigoCliente()
    {
        $comprobante2 = false;

        $post = $this->getRequest()->getPost();

        if (empty($post)) {
            $comprobante = false;
            $comprobante2 = false;
        } else {
            $customerCodeId = $post['customer_code_id'];
            $comprobante = $this->cexCustomercodeRepository
                ->deleteById($customerCodeId);

            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('id_cod_cliente', $customerCodeId, 'eq')
                ->create();

            $resultsCollection = $this->cexSavedsenderRepository
                ->getList($searchCriteria)
                ->getItems();

            foreach ($resultsCollection as $result) {
                $comprobante2 = $this->cexSavedsenderRepository
                    ->deleteById($result->getSenderId());
            }
        }

        if ($comprobante2) {
            $mensaje = array(
                'type' => 'success',
                'title' => __('Borrar código cliente'),
                'mensaje' => __('El código de cliente y sus remitentes asignados han sido borrados con éxito'),
            );
        } else {
            if ($comprobante) {
                $mensaje = array(
                    'type' => 'success',
                    'title' => __('Borrar código cliente'),
                    'mensaje' => __('El código de cliente ha sido borrado con éxito'),
                );
            } else {
                $mensaje = array(
                    'type' => 'error',
                    'title' => __('Borrar código cliente'),
                    'mensaje' => __('El código de cliente no se ha podido borrar'),
                );
            }
        }

        $retorno = array(
            'mensaje' => $mensaje,
            'codigos' => $this->retornarCodigosCliente(),
            'selectCodCliente' => $this->retornarSelectCodigosCliente(),
            'remitentes' => $this->retornarRemitentes(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
            'productos' => $this->retornarProductos(),
            'selectTransportistas' => $this->retornarTransportistas()
        );

        echo json_encode($retorno);

    }

    public function guardarRemitente()
    {
        $post = $this->getRequest()->getPost();

        if (empty($post)) {
            $comprobante = false;
        } else {
            $cexsavedSenderDTO = $this->cexSavedsenderFactory->create();

            $cexsavedSenderDTO->setName($this->getRequest()->getPost('name'));
            $cexsavedSenderDTO->setAddress($this->getRequest()->getPost('address'));
            $cexsavedSenderDTO->setPostCode($this->getRequest()->getPost('postcode'));
            $cexsavedSenderDTO->setCity($this->getRequest()->getPost('city'));
            $cexsavedSenderDTO->setIsoCodePais($this->getRequest()->getPost('iso_code'));
            $cexsavedSenderDTO->setContact($this->getRequest()->getPost('contact'));
            $cexsavedSenderDTO->setPhone($this->getRequest()->getPost('phone'));
            $cexsavedSenderDTO->setEmail($this->getRequest()->getPost('email'));
            $cexsavedSenderDTO->setFromHour($this->getRequest()->getPost('from_hour'));
            $cexsavedSenderDTO->setToHour($this->getRequest()->getPost('to_hour'));
            $cexsavedSenderDTO->setFromMinute($this->getRequest()->getPost('from_minute'));
            $cexsavedSenderDTO->setToMinute($this->getRequest()->getPost('to_minute'));
            $cexsavedSenderDTO->setIdCodCliente($this->getRequest()->getPost('codigo_cliente'));

            if ($this->cexSavedsenderRepository->save($cexsavedSenderDTO)) {
                $comprobante = true;
            } else {
                $comprobante = false;
            }
        }

        if ($comprobante) {
            $mensaje = array(
                'type' => 'success',
                'title' => __('Crear remitente'),
                'mensaje' => __('El remitente ha sido creado con exito')
            );
        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Crear remitente'),
                'mensaje' => __('El remitente no se ha podido crear')
            );
        }

        $retorno = array(
            'mensaje' => $mensaje,
            'codigos' => $this->retornarCodigosCliente(),
            'selectCodCliente' => $this->retornarSelectCodigosCliente(),
            'remitentes' => $this->retornarRemitentes(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
            'productos' => $this->retornarProductos(),
            'selectTransportistas' => $this->retornarTransportistas()
        );

        echo json_encode($retorno);

    }

    public function guardarRemitenteDefecto()
    {
        $senderId = $this->getRequest()->getPost('sender_id');

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('clave', 'MXPS_DEFAULTSEND', 'eq')
            ->create();

        $customeroptionToEdit = $this->cexCustomeroptionRepository
            ->getList($searchCriteria)
            ->getItems();

        $codigo = reset($customeroptionToEdit);
        if ($senderId == 0) {
            $comprobante = false;
        } else {
            $codigo->setValor($senderId);

            $comprobante = $this->cexCustomeroptionRepository->save($codigo);
        }

        if ($comprobante) {
            $mensaje = array(
                'type' => 'success',
                'title' => __('Guardar remitente defecto'),
                'mensaje' => __('El remitente por defecto se ha actualizado correctamente')
            );
        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Guardar remitente defecto'),
                'mensaje' => __('No se ha podido guardar el remitente por defecto')
            );
        }

        $retorno = array(
            'mensaje' => $mensaje,
            'codigos' => $this->retornarCodigosCliente(),
            'selectCodCliente' => $this->retornarSelectCodigosCliente(),
            'remitentes' => $this->retornarRemitentes(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
            'productos' => $this->retornarProductos(),
            'selectTransportistas' => $this->retornarTransportistas()
        );

        echo json_encode($retorno);
    }

    public function retornarRemitente()
    {
        $senderId = $this->getRequest()->getPost('sender_id');

        $resultsCollection = $this->cexSavedsenderCollectionFactory
            ->create()
            ->getData();

        foreach ($resultsCollection as $itemRespuesta) {
            if ($itemRespuesta['sender_id'] == $senderId) {
                $remitente = $itemRespuesta;
            }
        }

        $customerCodeId = $remitente['id_cod_cliente'];

        $resultsCollectionCustomer = $this->cexCustomercodeCollectionFactory
            ->create()
            ->getData();

        foreach ($resultsCollectionCustomer as $itemRespuesta) {
            if ($itemRespuesta['customer_code_id'] == $customerCodeId) {
                $codigo = $itemRespuesta;
            }
        }

        $customerCode = $codigo['customer_code'];
        $remitente['customer_code_id'] = $customerCode;

        echo json_encode($remitente);
    }

    private function retornarRemitentes(): ?string
    {
        $resultsSenderCollection = $this->cexSavedsenderCollectionFactory
            ->create()
            ->getData();

        if (sizeof($resultsSenderCollection) == 0) {
            return null;
        }

        $retorno = "
        <thead>
            <tr>
                <th align='center'></th>
                <th align='center'></th>
                <th>" . __('Nombre') . "</th>
                <th>" . __('Cod. Cli.') . "</th>
                <th>" . __('Dirección') . "</th>
                <th>" . __('CP') . "</th>
                <th>" . __('Ciudad') . "</th>
                <th>" . __('País') . "</th>
                <th>" . __('Contacto') . "</th>
                <th>" . __('Teléfono') . "</th>
                <th>" . __('Email') . "</th>
                <th>" . __('Desde') . "</th>
                <th>" . __('Hasta') . "</th>
            </tr>
        </thead>
        <tbody>";
        foreach ($resultsSenderCollection as $registro) {
            $customerCodeId = $registro['id_cod_cliente'];

            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('customer_code_id', $customerCodeId, 'eq')
                ->create();

            $codigo = $this->cexCustomercodeRepository
                ->getList($searchCriteria)
                ->getItems();

            $codigo = reset($codigo);

            $codigoCliente = $codigo->getCustomerCode();

            $desde = sprintf("%02d", $registro['from_hour']) . ':' . sprintf("%02d", $registro['from_minute']);
            $hasta = sprintf("%02d", $registro['to_hour']) . ':' . sprintf("%02d", $registro['to_minute']);
            $linea = "
            <tr class='fila'>
                <td>
                    <a id='" . $registro['sender_id'] . "' tabindex='' class='CEX-btn CEX-button-blue cex_actualizar_remitente d-inline-block' onclick='pedirRemitente(this.id);'>
                        <i class='fas fa-pencil-alt'></i>
                    </a>
                </td>
                <td>
                    <a id='" . $registro['sender_id'] . "' tabindex='' class='CEX-btn CEX-button-cancel cex_borrar_remitente d-inline-block' onclick='borrarRemitente(this.id);'>
                        <i class='fas fa-times'></i>
                    </a>
                </td>
                <td>" . $registro['name'] . "</td>
                <td>" . $codigoCliente . "</td>
                <td>" . $registro['address'] . "</td>
                <td>" . $registro['postcode'] . "</td>
                <td>" . $registro['city'] . "</td>
                <td>" . $registro['iso_code_pais'] . "</td>
                <td>" . $registro['contact'] . "</td>
                <td>" . $registro['phone'] . "</td>
                <td>" . $registro['email'] . "</td>
                <td>" . $desde . "</td>
                <td>" . $hasta . "</td>
            </tr>";

            $retorno .= $linea;
        }

        $retorno .= "</tbody>";
        return $retorno;
    }

    private function retornarSelectRemitentes(): string
    {

        $resultsSenderCollection = $this->cexSavedsenderCollectionFactory
            ->create()
            ->getData();

        if (sizeof($resultsSenderCollection) == 0) {
            $select = " <select id='MXPS_DEFAULTSEND' name='MXPS_DEFAULTSEND' class='form-control' disabled>
                            <option disabled='disabled' selected>" . __('No hay remitentes dados de alta') . "</option>
                        </select>";
        } else {
            $remitenteDefectoId = $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTSEND');
            $cabecera = "<select id='MXPS_DEFAULTSEND' name='MXPS_DEFAULTSEND' class='form-control'>";
            $contenido = '';
            $existeRemitenteDefecto = 0;

            foreach ($resultsSenderCollection as $registro) {
                if ($remitenteDefectoId == $registro['sender_id']) {
                    $contenido .= " <option value='" . $registro['sender_id'] . "' selected>" . $registro['name'] . "</option>";
                    $existeRemitenteDefecto = 1;
                } else {
                    $contenido .= " <option value='" . $registro['sender_id'] . "'>" . $registro['name'] . "</option>";
                }
            }

            if ($existeRemitenteDefecto == 0) {
                $contenido = " <option value='0' disabled='disabled' selected>" . __('Seleccionar remitente por defecto') . "</option>" . $contenido;
            }

            $footer = "</select>";
            $select = $cabecera . $contenido . $footer;
        }
        return $select;
    }

    public function borrarRemitente()
    {
        $senderId = $this->getRequest()->getPost('sender_id');

        $comprobante = $this->cexSavedsenderRepository
            ->deleteById($senderId);

        if ($comprobante) {

            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('clave', 'MXPS_DEFAULTSEND', 'eq')
                ->create();

            $customerOptionModel = $this->cexCustomeroptionRepository
                ->getList($searchCriteria)
                ->getItems();

            $customerOptionModel = reset($customerOptionModel);

            $savedSenderValor = $customerOptionModel->getValor();
            $savedSenderClave = $customerOptionModel->getClave();

            if ($savedSenderValor == $senderId) {

                $customerOptionModel->setValor($savedSenderClave);

                $this->cexCustomeroptionRepository->save($customerOptionModel);

                $mensaje = array(
                    'type' => 'success',
                    'title' => __('Borrar remitente'),
                    'mensaje' => __('El remitente ha sido borrado correctamente. Ahora no tiene remitentes por defecto')
                );
            } else {
                $mensaje = array(
                    'type' => 'success',
                    'title' => __('Borrar remitente'),
                    'mensaje' => __('El remitente ha sido borrado correctamente')
                );
            }

        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Borrar remitente'),
                'mensaje' => __('El remitente no podido ser borrado')
            );
        }
        $retorno = array(
            'mensaje' => $mensaje,
            'remitentes' => $this->retornarRemitentes(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
        );

        echo json_encode($retorno);
        exit;
    }

    public function actualizarRemitente()
    {
        $idSender = $this->getRequest()->getPost('sender_id');

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('sender_id', $idSender, 'eq')
            ->create();

        $savedSenderModel = $this->cexSavedsenderRepository
            ->getList($searchCriteria)
            ->getItems();

        $savedSenderModel = reset($savedSenderModel);

        $savedSenderModel->setSenderId($this->getRequest()->getPost('sender_id'));
        $savedSenderModel->setName($this->getRequest()->getPost('name'));
        $savedSenderModel->setAddress($this->getRequest()->getPost('address'));
        $savedSenderModel->setPostCode($this->getRequest()->getPost('postcode'));
        $savedSenderModel->setCity($this->getRequest()->getPost('city'));
        $savedSenderModel->setIsoCodePais($this->getRequest()->getPost('iso_code'));
        $savedSenderModel->setContact($this->getRequest()->getPost('contact'));
        $savedSenderModel->setPhone($this->getRequest()->getPost('phone'));
        $savedSenderModel->setEmail($this->getRequest()->getPost('email'));
        $savedSenderModel->setFromHour($this->getRequest()->getPost('from_hour'));
        $savedSenderModel->setToHour($this->getRequest()->getPost('to_hour'));
        $savedSenderModel->setFromMinute($this->getRequest()->getPost('from_minute'));
        $savedSenderModel->setToMinute($this->getRequest()->getPost('to_minute'));

        $comprobante = $this->cexSavedsenderRepository->save($savedSenderModel);

        if ($comprobante) {
            $mensaje = array(
                'type' => 'success',
                'title' => __('Actualizar remitente'),
                'mensaje' => __('Remitente actualizado con exito')
            );
        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Actualizar remitente'),
                'mensaje' => __('El remitente no se ha podido actualizar')
            );
        }

        $retorno = array(
            'mensaje' => $mensaje,
            'remitentes' => $this->retornarRemitentes(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
        );

        echo json_encode($retorno);
    }


    public function getUserConfig()
    {
        $resultsCollection = $this->cexCustomeroptionCollectionFactory
            ->create()
            ->getData();

        if (sizeof($resultsCollection) == 0) {
            return null;
        }

        $ast = '*****';
        foreach ($resultsCollection as $result) {
            if ($result['clave'] == 'MXPS_USER') {
                $result['valor'] = substr($this->_cexHelpers->cexEncryptDecrypt('decrypt', $result['valor']), 0, 1) . $ast;
            }
            $retorno[$result['clave']] = $result['valor'];
        }
        $retorno["MXPS_PASSWD"] = $ast;
        if (strcmp('', $retorno['MXPS_DEFAULTPDF']) == 0) {
            $retorno['MXPS_DEFAULTPDF'] = '1';
        }

        echo json_encode($retorno);
    }

    public function validarCredenciales()
    {
        $this->_cexRest->cexValidarCredenciales();
    }

    private function actualizarCustomerOptions($campo, $valorCampo = '')
    {
        if ($valorCampo == '') {
            $valorCampo = $this->getRequest()->getPost("$campo");
        }

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('clave', $campo, 'eq')
            ->create();

        $customerOptionResult = $this->cexCustomeroptionRepository
            ->getList($searchCriteria)
            ->getItems();

        $customerOptionResult = reset($customerOptionResult);

        $customerOptionResult->setValor($valorCampo);

        $comprobante = $this->cexCustomeroptionRepository->save($customerOptionResult);

        return $comprobante;
    }

    private function actualizarCustomerOptionsInterno($campo, $valor = '')
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('clave', $campo, 'eq')
            ->create();

        $customerOptionResult = $this->cexCustomeroptionRepository
            ->getList($searchCriteria)
            ->getItems();

        $customerOptionResult = reset($customerOptionResult);

        $customerOptionResult->setValor($valor);

        return $this->cexCustomeroptionRepository->save($customerOptionResult);
    }

    public function guardarCredenciales()
    {
        $comprobante = false;

        if ($_POST['MXPS_USER'] != '' && $_POST['MXPS_PASSWD'] != '') {

            foreach ($_POST as $key => $value) {
                if ($key != 'action' && $key != 'form_key') {
                    if ($key == 'MXPS_PASSWD') {
                        $_POST['MXPS_PASSWD'] = $this->_cexHelpers->cexEncryptDecrypt('encrypt', $_POST['MXPS_PASSWD']);
                    } else if ($key == 'MXPS_USER') {
                        $_POST['MXPS_USER'] = $this->_cexHelpers->cexEncryptDecrypt('encrypt', $_POST['MXPS_USER']);
                    }
                    $comprobante = $this->actualizarCustomerOptionsInterno($key, $_POST[$key]);
                }
            }
            if ($comprobante == true) {
                $mensaje = array(
                    'type' => 'success',
                    'title' => __('Actualizar datos del usuario'),
                    'mensaje' => __('Los datos se han actualizado correctamente')
                );
            } else {
                $mensaje = array(
                    'type' => 'error',
                    'title' => __('Actualizar datos del usuario'),
                    'mensaje' => __('Los datos no han sido modificados')
                );
            }
        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Actualizar datos del usuario'),
                'mensaje' => __('Los datos no han sido guardados')
            );
        }
        $retorno = array(
            'mensaje' => $mensaje,
        );
        echo json_encode($retorno);
        exit;
    }

    public function guardarCustomerOptions()
    {

        $comprobante = false;

        $updateUserConf = array(
            'MXPS_WSURL' => $this->getRequest()->getPost('MXPS_WSURL'),
            'MXPS_WSURLREC' => $this->getRequest()->getPost('MXPS_WSURLREC'),
            'MXPS_WSURLSEG' => $this->getRequest()->getPost('MXPS_WSURLSEG'),
            'MXPS_ENABLEWEIGHT' => $this->getRequest()->getPost('MXPS_ENABLEWEIGHT'),
            'MXPS_DEFAULTKG' => $this->getRequest()->getPost('MXPS_DEFAULTKG'),
            'MXPS_CHECK_LOG' => $this->getRequest()->getPost('MXPS_CHECK_LOG'),
            'MXPS_ENABLESHIPPINGTRACK' => $this->getRequest()->getPost('MXPS_ENABLESHIPPINGTRACK'),
            'MXPS_DEFAULTBUL' => $this->getRequest()->getPost('MXPS_DEFAULTBUL'),
            'MXPS_DEFAULTPDF' => $this->getRequest()->getPost('MXPS_DEFAULTPDF'),
            'MXPS_DEFAULTPAYBACK' => $this->getRequest()->getPost('MXPS_DEFAULTPAYBACK'),
            'MXPS_DEFAULTDELIVER' => $this->getRequest()->getPost('MXPS_DEFAULTDELIVER'),
            'MXPS_LABELSENDER' => $this->getRequest()->getPost('MXPS_LABELSENDER'),
            'MXPS_LABELSENDER_TEXT' => $this->getRequest()->getPost('MXPS_LABELSENDER_TEXT'),
            'MXPS_NODATAPROTECTION' => $this->getRequest()->getPost('MXPS_NODATAPROTECTION'),
            'MXPS_DATAPROTECTIONVALUE' => $this->getRequest()->getPost('MXPS_DATAPROTECTIONVALUE'),
            'MXPS_OBSERVATIONS' => $this->getRequest()->getPost('MXPS_OBSERVATIONS'),
            'MXPS_TRACKING' => $this->getRequest()->getPost('MXPS_TRACKING'),
            'MXPS_REFETIQUETAS' => $this->getRequest()->getPost('MXPS_REFETIQUETAS'),
        );

        foreach ($updateUserConf as $key => $value) {
            if ($value != '') {
                $comprobante = $this->actualizarCustomerOptions($key);
            }
        }

        if ($comprobante) {
            $mensaje = array(
                'type' => 'success',
                'title' => __('Guardar configuración de usuario'),
                'mensaje' => __('La configuración se ha actualizado con éxito')
            );
        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Guardar configuración de usuario'),
                'mensaje' => __('No se ha podido actualizar la configuración de usuario')
            );
        }

        $retorno = array(
            'mensaje' => $mensaje
        );

        echo json_encode($retorno);
    }

    public function guardarImagenLogo()
    {
        $MXPS_CHECKUPLOADFILE = $this->getRequest()->getPost('MXPS_CHECKUPLOADFILE');
        $retorno = array(
            'mensaje' => '',
            'imagenLogo' => ''
        );
        if (strcmp('true', $MXPS_CHECKUPLOADFILE) == 0) {
            if (!empty($_FILES['MXPS_UPLOADFILE'])) {
                $this->eliminarLogo(true);
                if ($_FILES['MXPS_UPLOADFILE']['size'] >= 400000) {
                    $mensaje = array(
                        'type' => 'error',
                        'title' => __('Guardar configuración de usuario'),
                        'mensaje' => __('El logo es demasiado grande, debe ser menor de 400 kB'),
                    );
                    $retorno['mensaje'] = $mensaje;
                } else {
                    switch ($_FILES['MXPS_UPLOADFILE']['type']) {
                        case 'image/jpeg':
                            $retorno = $this->guardarLogo("LogoImagen.jpeg");
                            break;
                        case 'image/png':
                            $retorno = $this->guardarLogo("LogoImagen.png");
                            break;
                        case 'image/jpg':
                            $retorno = $this->guardarLogo("LogoImagen.jpg");
                            break;
                        case 'image/gif':
                            $retorno = $this->guardarLogo("LogoImagen.gif");
                            break;
                        default:
                            $mensaje = array(
                                'type' => 'error',
                                'title' => __('Guardar configuración de usuario'),
                                'mensaje' => __('Formato Inválido (JPG/PNG)'),
                            );
                            $retorno['mensaje'] = $mensaje;
                            break;
                    }
                }
            } else {
                $mensaje = array(
                    'type' => 'error',
                    'title' => __('Guardar configuración de usuario'),
                    'mensaje' => __('Suba una imagen para el logo por favor'),
                );
                $retorno['mensaje'] = $mensaje;
            }
        } else {
            $retorno = $this->eliminarLogo(true);
        }
        echo json_encode($retorno);
        exit;
    }

    private function eliminarLogo($ajax = false)
    {

        $this->actualizarCustomerOptions('MXPS_UPLOADFILE', ' ');
        $this->actualizarCustomerOptions('MXPS_CHECKUPLOADFILE', 'false');
        $archivos = array("LogoImagen.gif", "LogoImagen.png", "LogoImagen.jpeg", "LogoImagen.jpg");
        foreach ($archivos as $archivo) {
            $url = dirname(__FILE__, 4) . "/view/adminhtml/web/images/" . $archivo;
            if (file_exists($url)) {
                unlink($url);
            }
        }
        $mensaje = array(
            'type' => 'error',
            'title' => __('Guardar configuración de usuario'),
            'mensaje' => __('Imagen eliminada'),
        );
        $retorno = array(
            'mensaje' => $mensaje,
            'imagenLogo' => ''
        );

        if ($ajax === true) {
            return $retorno;
        }

        echo json_encode($retorno);
        exit;
    }

    private function guardarLogo($fileName): array
    {

        $path2Move = dirname(__FILE__, 4) . "/view/adminhtml/web/images/";
        $uploader = $this->_fileUploaderFactory->create(['fileId' => 'MXPS_UPLOADFILE']);
        $uploader->save($path2Move, $fileName);

        $rutaLogo = 'CorreosExpress_RegistroDeEnvios::images/' . $fileName;
        $asset = $this->_assetRepo->createAsset($rutaLogo);
        $path = $asset->getUrl($rutaLogo);

        $this->actualizarCustomerOptions('MXPS_UPLOADFILE', $path);
        $this->actualizarCustomerOptions('MXPS_CHECKUPLOADFILE', 'true');

        $mensaje = array(
            'type' => 'success',
            'title' => __('Guardar configuración de usuario'),
            'mensaje' => __('Logo para las etiquetas guardado'),
        );
        $retorno = array(
            'mensaje' => $mensaje,
            'imagenLogo' => $path
        );
        return $retorno;
    }

    public function ejecutarCron()
    {
        $this->purgarTablas();
        $this->_cexHelpers->ejecutarCexCron();
    }

    private function getOrderStatusCore(): ?string
    {
        $resultsCollection = $this->statusCollection->toOptionArray();
        if (sizeof($resultsCollection) == 0) {
            return null;
        }
        $retorno = '<option value="" >' . __('Selecciona un estado') . '</option>';
        foreach ($resultsCollection as $result) {
            $clave = $result['value'];
            $valor = $result['label'];
            $retorno .= "<option value='" . $clave . "'>" . $valor . "</option>";
        }

        return $retorno;
    }

    private function purgarTablas()
    {
        $resultsCollection = $this->cexEnvioCronRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($resultsCollection as $result) {
            $this->cexEnvioCronRepository
                ->delete($result);
        }
    }

    public function guardarDatosCron()
    {

        $updateCronConf = array(
            'MXPS_RECORDSTATUS' => $this->getRequest()->getPost('MXPS_RECORDSTATUS'),
            'MXPS_SAVEDSTATUS' => $this->getRequest()->getPost('MXPS_SAVEDSTATUS'),
            'MXPS_TRACKINGCEX' => $this->getRequest()->getPost('MXPS_TRACKINGCEX'),
            'MXPS_CHANGESTATUS' => $this->getRequest()->getPost('MXPS_CHANGESTATUS'),
            'MXPS_SENDINGSTATUS' => $this->getRequest()->getPost('MXPS_SENDINGSTATUS'),
            'MXPS_DELIVEREDSTATUS' => $this->getRequest()->getPost('MXPS_DELIVEREDSTATUS'),
            'MXPS_CANCELEDSTATUS' => $this->getRequest()->getPost('MXPS_CANCELEDSTATUS'),
            'MXPS_RETURNEDSTATUS' => $this->getRequest()->getPost('MXPS_RETURNEDSTATUS'),
            'MXPS_CRONTYPE' => $this->getRequest()->getPost('MXPS_CRONTYPE')
        );

        $cronTabXML = dirname(__DIR__, 3) . '/etc/crontab.xml';
        $cronTabXMLBody = '<?xml version="1.0"?>
                           <config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Cron:etc/crontab.xsd">
                                <group id="default">
                                    <job name="cexCron" instance="CorreosExpress\RegistroDeEnvios\CexCron\CexCron" method="execute">
                                        <schedule>* */4 * * *</schedule>
                                    </job>
                                </group>
                            </config>';


        if (strcmp('cron', $updateCronConf['MXPS_CRONTYPE']) == 0) {
            if (!file_exists($cronTabXML)) {
                file_put_contents(dirname(__DIR__, 3) . '/etc/crontab.xml', print_r($cronTabXMLBody, true), LOCK_EX);
            }
        } else {
            if (!unlink($cronTabXML)) {
                $mensaje = array(
                    'type' => 'error',
                    'title' => __('Guardar configuración del cron'),
                    'mensaje' => __('No se puede quitar la tarea programada')
                );
                $retorno = array(
                    'mensaje' => $mensaje
                );
                echo json_encode($retorno);
                exit;
            }

        }

        foreach ($updateCronConf as $key => $value) {
            $comprobante = $this->actualizarCustomerOptions($key, $value);
        }

        if ($comprobante) {
            $mensaje = array(
                'type' => 'success',
                'title' => __('Guardar configuración del cron'),
                'mensaje' => __('La configuración se ha actualizado con éxito')
            );
        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Guardar configuración del cron'),
                'mensaje' => __('No se ha podido actualizar la configuración del cron')
            );
        }

        $retorno = array(
            'mensaje' => $mensaje
        );
        echo json_encode($retorno);
    }

    public function generarCron()
    {
        $retorno = '';
        $nombreArchivo = $_POST['nombre'];
        switch ($nombreArchivo) {
            case 'log_cron':
                $retorno = $this->generarLogCron();
                break;
            case 'peticion':
                $retorno = $this->generarLogPeticionCron();
                break;
            case 'respuesta':
                $retorno = $this->generarLogRespuestaCron();
                break;
            default:
                break;
        }
        echo $retorno;
        exit();
    }

    private function generarLogCron(): string
    {
        $respuesta = '';

        $respuestaCronCollection = $this->cexRespuestaCronCollectionFactory
            ->create();

        $respuestaCronCollection->getSelect()
            ->joinLeft(
                ['saved' => $this->_resource->getTableName('correosexpress_registrodeenvios_cexsavedships')],
                'main_table.nEnvioCliente = saved.num_ship',
                ['ship_id', 'num_collect', 'status']
            );

        $data = $respuestaCronCollection->getData();

        foreach ($data as $item) {
            $respuesta .= "\n\n ORDEN: " . $item['ship_id'];
            $respuesta .= "\n CÓDIGO DE CLIENTE: " . $item['codCliente'] . "\n";
            $respuesta .= "\t- Fecha de ejecución del cron -> " . $item['created_at'] . "\n";
            $respuesta .= "\t- Referencia -> " . $item['num_collect'] . "\n";
            $respuesta .= "\t- Código de estado antes del Cron -> " . $item['estadoAntiguo'] . " con estado -> " . $item['status'] . "\n";
            $respuesta .= "\t- Estado Actual en WS -> " . $item['codigoEstado'] . " con el estado -> " . $item['descripcionEstado'] . "\n";
        }
        $respuesta .= "\n\n\t\t\tFIN DE EJECUCIÓN DEL CRON";
        return $respuesta;
    }

    private function generarLogPeticionCron(): string
    {
        $respuesta = '';

        $respuestaCronCollection = $this->cexRespuestaCronCollectionFactory
            ->create();

        $respuestaCronCollection->getSelect()
            ->joinLeft(
                ['saved' => $this->_resource->getTableName('correosexpress_registrodeenvios_cexsavedships')],
                'main_table.nEnvioCliente = saved.num_ship',
                ['ship_id', 'num_collect', 'status']
            )->joinLeft(
                ['envio' => $this->_resource->getTableName('correosexpress_registrodeenvios_cexenvioscron')],
                'main_table.id_respuesta_cron = envio.id_envio_cron',
                ['peticion_envio']
            );

        $data = $respuestaCronCollection->getData();

        foreach ($data as $item) {
            $respuesta .= "\t ORDEN: " . $item['ship_id'];
            $respuesta .= "\n ********************CÓDIGO DE CLIENTE: " . $item['codCliente'] . "\n";
            $respuesta .= "********************PETICIÓN DE ENVÍO: \n\t" . $item['peticion_envio'] . "\n";
            $respuesta .= "\t- Fecha de ejecución del cron -> " . $item['created_at'] . "\n";
            $respuesta .= "\t- Referencia -> " . $item['num_collect'] . "\n";
            $respuesta .= "\t- Número de envío -> " . $item['nEnvioCliente'] . "\n";
            $respuesta .= "\n************************************************************************************************************\n\n\n";
        }
        return $respuesta;
    }

    private function generarLogRespuestaCron(): string
    {
        $respuesta = '';

        $data = $this->cexEnvioCronRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($data as $item) {
            $respuesta .= "\n ********************CÓDIGO DE CLIENTE: " . $item->getCodCliente() . "\n";
            $respuesta .= "\n ********************RESPUESTA DEL WS:\n" . print_r(json_decode($item->getRespuestaEnvio(), true), true) . "\n";
            $respuesta .= "\n************************************************************************************************************\n";
        }
        return $respuesta;
    }

    private function retornarProductos(): string
    {
        $resultsModeShipCollection = $this->cexSavedmodeshipCollectionFactory
            ->create()
            ->getData();

        $container = '<div class="row">';
        $row1 = '<div class="col-6 col-xs-12 col-sm-6 col-lg-6">';
        $row2 = '<div class="col-6 col-xs-12 col-sm-6 col-lg-6">';
        $endRow = '</div>';

        $iterador = 0;
        foreach ($resultsModeShipCollection as $producto) {

            $elemento = '<div class="form-group my-2 d-flex">';

            if ($producto['checked']) {
                $elemento .= '<input type="checkbox" id="prod' . $producto['id_bc'] . '" name="MXPS_SELMODESHIP" class="form-control m-1 d-inline-block check_productos before" value="' . $producto['id_bc'] . '" checked><label for="prod' . $producto['id_bc'] . '" class="d-inline-block ml-2">' . $producto['name'] . '</label>';
            } else {
                $elemento .= '<input type="checkbox" id="prod' . $producto['id_bc'] . '" name="MXPS_SELMODESHIP" class="form-control m-1 d-inline-block check_productos before" value="' . $producto['id_bc'] . '"><label for="prod' . $producto['id_bc'] . '" class="d-inline-block ml-2">' . $producto['name'] . '</label>';
            }

            $elemento .= '</div>';

            if ($iterador <= (sizeof($resultsModeShipCollection) / 2)) {
                $row1 .= $elemento;
            } else {
                $row2 .= $elemento;
            }

            $iterador++;
        }

        return $container . $row1 . $endRow . $row2 . $endRow . $endRow;
    }

    public function guardarProductosCex()
    {
        $productos = $this->getRequest()->getPost('nodos_activos');
        $productos = array_filter(explode(';', $productos));

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('checked', '0', 'eq')
            ->create();

        $savedmodeshipNoActive = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        $modeshipsIdNotActive = array();

        foreach ($savedmodeshipNoActive as $item) {
            array_push($modeshipsIdNotActive, $item->getModeShipsId());
        }

        if (is_array($productos) && count($productos) >= 1 && !empty($productos[0])) {
            $comprobanteCheckArray = array();
            $comprobanteNoCheckArray = array();
            foreach ($productos as $producto) {
                array_push($comprobanteNoCheckArray, $producto);
                array_push($comprobanteCheckArray, $producto);
            }

            $update_check = $this->activarDesactivarProducto($comprobanteCheckArray, true);
            $update_no_checked = $this->activarDesactivarProducto($comprobanteNoCheckArray, false);

            $comprobante = $update_check + $update_no_checked;

        } else {
            $savedModeShipList = $this->cexSavedmodeshipRepository
                ->getList($this->searchCriteriaBuilder->create())
                ->getItems();

            foreach ($savedModeShipList as $item) {
                $item->setChecked(0);

                $this->cexSavedmodeshipRepository->save($item);
            }
        }

        $results = $this->cexSavedmodeshipRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        if (sizeof($results) != 0) {
            foreach ($results as $result) {
                $rest = $this->recuperarIdCarrierByIDBC($result->getIdBc());
                if ($result->getChecked() == 1) {
                    if (in_array($result->getModeShipsId(), $modeshipsIdNotActive, true) == 1) {
                        $this->activarDesctivarTransportista($rest, "1");

                        $idCarrier = ";" . $rest . ";";

                        $result->setIdCarrier($idCarrier);

                        $this->cexSavedmodeshipRepository->save($result);
                    }
                } else {
                    $this->activarDesctivarTransportista($rest, "0");
                }
            }
        }

        if ($comprobante >= 1) {
            $mensaje = array(
                'type' => 'success',
                'title' => __('Guardar productos'),
                'mensaje' => __('Los productos se han actualizado correctamente')
            );
        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Guardar productos'),
                'mensaje' => __('Los productos no se han actualizado')
            );
        }

        $retorno = array(
            'mensaje' => $mensaje,
            'productos' => $this->retornarProductos(),
            'selectTransportistas' => $this->retornarTransportistas()
        );

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('checked', '1', 'eq')
            ->create();

        $ModeShipsActive = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        $modeshipsIdBcActive = array();

        foreach ($ModeShipsActive as $item) {
            array_push($modeshipsIdBcActive, $item->getIdBc());
        }

        $search = array_search('44', $modeshipsIdBcActive);

        if ($search === false) {
            $this->crearBorrarLayoutXmlEtnOfi(false);
        } else {
            $this->crearBorrarLayoutXmlEtnOfi(true);
        }

        echo json_encode($retorno);
        exit;
    }

    private function crearBorrarLayoutXmlEtnOfi($crear)
    {
        $urlXMLFile = dirname(__DIR__, 3) . '/view/frontend/layout/checkout_index_index.xml';
        if ($crear === true) {

            $fileXMLBody = '<?xml version="1.0"?>
    <page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" layout="1column" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <head>
        <css src="CorreosExpress_RegistroDeEnvios::css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <css src="CorreosExpress_RegistroDeEnvios::css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <css src="CorreosExpress_RegistroDeEnvios::css/fontawesome.min.css" rel="stylesheet" type="text/css"/>
        <css src="CorreosExpress_RegistroDeEnvios::css/correosexpress.css" rel="stylesheet" type="text/css"/>
    </head>
        <body>
            <referenceBlock name="checkout.root">
                    <arguments>
                        <argument name="jsLayout" xsi:type="array">
                            <item name="components" xsi:type="array">
                                <item name="checkout" xsi:type="array">
                                    <item name="children" xsi:type="array">
                                        <item name="steps" xsi:type="array">
                                            <item name="children" xsi:type="array">
                                                <item name="shipping-step" xsi:type="array">
                                                    <item name="children" xsi:type="array">
                                                        <item name="shippingAddress" xsi:type="array">
                                                                <item name="children" xsi:type="array">
                                                                    <item name="before-shipping-method-form" xsi:type="array">
                                                                        <item name="children" xsi:type="array">
                                                                            <item name="shipping_custom_block" xsi:type="array">
                                                                                <item name="component" xsi:type="string">CorreosExpress_RegistroDeEnvios/js/view/shipping/customblock</item>
                                                                            </item>
                                                                        </item>
                                                                    </item>
                                                                </item>
                                                        </item>
                                                    </item>
                                                </item>
                                            </item>
                                        </item>
                                    </item>
                                </item>
                            </item>
                        </argument>
                    </arguments>
            </referenceBlock>
        </body>
    </page>';

            if (!file_exists($urlXMLFile)) {
                file_put_contents($urlXMLFile, print_r($fileXMLBody, true), LOCK_EX);
            }
        } else {
            if (file_exists($urlXMLFile)) {
                unlink($urlXMLFile);
            }
        }
    }

    private function activarDesactivarProducto($producto, $activar): bool
    {
        $check = 0;
        $condicion = 'nin';
        if ($activar == true) {
            $check = 1;
            $condicion = 'in';
        }

        $filter[] = $this->filterBuilder
            ->setField('id_bc')
            ->setValue($producto)
            ->setConditionType($condicion)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($filter)
            ->create();

        $savedModeShipList = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($savedModeShipList as $item) {
            $item->setChecked($check);
            $save = $this->cexSavedmodeshipRepository->save($item);
            if (!$save) {
                return false;
            }
        }
        return true;

    }

    private function retornarTransportistas(): string
    {
        $outerHTML = '';
        $activeCarriers = $this->shipconfig->getActiveCarriers();
        $div = '<div class="row">';

        foreach ($activeCarriers as $carrierCode => $carrierModel) {
            $carrierTitle = $this->scopeConfig->getValue('carriers/' . $carrierCode . '/title');
            $outerHTML .= '<div id="nombreCarriersProductos" class="col-12 col-sm-6 col-md-6 col-lg-6">
                <div class="input-group my-3"><div class="input-group-prepend">
                <span id="nombreCarriers" class="input-group-text rounded-left">' . $carrierTitle . '</span></div>';
            $outerHTML .= $this->retornarSelectProductosActivosZonas($carrierCode);
            $outerHTML .= '</div></div>';
        }
        $divfooter = '</div>';

        return $div . $outerHTML . $divfooter;

    }

    private function recuperarIdCarrierByIDBC($idbc): string
    {
        switch ($idbc) {
            case '61':
                $rest = "cexpaq10";
                break;
            case '62':
                $rest = "cexpaq14";
                break;
            case '63':
                $rest = "cexpaq24";
                break;
            case '66':
                $rest = "cexbaleares";
                break;
            case '67':
                $rest = "cexcanarias";
                break;
            case '68':
                $rest = "cexcanariasaereo";
                break;
            case '69':
                $rest = "cexcanariasmaritimo";
                break;
            case '73':
                $rest = "cexportugal";
                break;
            case '76':
                $rest = "cexpaqoptica";
                break;
            case '91':
                $rest = "cexpaqinternacional";
                break;
            case '90':
                $rest = "cexpaqinterestandar";
                break;
            case '92':
                $rest = "cexpaqempresa14";
                break;
            case '93':
                $rest = "cexepaq24";
                break;
            case '27':
                $rest = "cexcampaña";
                break;
            case '44':
                $rest = "cexEntregaOficina";
                break;
            case '54':
                $rest = "cexentregamultichrono";
                break;
            case '55':
                $rest = "cexentregamanipmultichrono";
                break;
            case '26':
                $rest = "cexislasexpress";
                break;
            case '46':
                $rest = "cexislasdoc";
                break;
            case '79':
                $rest = "cexislasmaritimo";
                break;
            default:
                $rest = "caxpaq24";
                break;
        }
        return $rest;
    }

    private function activarDesctivarTransportista($id_carrier, $value)
    {
        if (strpos($id_carrier, ";") === false) {
            $this->configWriter->save('carriers/' . $id_carrier . '/active', $value);
        } else {
            $id_carrier_array = explode(';', $id_carrier);
            foreach ($id_carrier_array as $res) {
                if (strpos($res, "cex") === 0) {
                    $this->configWriter->save('carriers/' . $res . '/active', $value);
                }
            }
        }
    }

    private function retornarSelectProductosActivosZonas($idCarrier): string
    {

        $contenido = '';

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('checked', '1', 'eq')
            ->create();

        $results = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        if (sizeof($results) == 0) {
            $select = " <select id=nombreProductos" . $idCarrier . " name='" . $idCarrier . "' class='form-control' disabled>
            <option value=' '>" . __('No hay productos CEX activos') . "</option>
            </select>";
        } else {
            $cabecera = "<select id=nombreProductos" . $idCarrier . " name='" . $idCarrier . "' class='form-control'>";

            $contenido .= " <option value='0'>" . __('No corresponde a productos CEX') . "</option>";

            foreach ($results as $result) {
                if (is_numeric(strpos($result['id_carrier'], ';' . $idCarrier . ';'))) {
                    $contenido .= " <option value='" . (int)$result->getIdBc() . "' selected >" . $result->getName() . "</option>";
                } else {
                    $contenido .= " <option value='" . (int)$result->getIdBc() . "' >" . $result->getName() . "</option>";
                }
            }

            $footer = "</select>";
            $select = $cabecera . $contenido . $footer;
        }

        return $select;
    }

    public function guardarMapeoTransportistas()
    {

        $formulario = $this->getRequest()->getPost('formulario');
        $formulario = json_decode($formulario, true);
        $comprobante = 0;

        $results = $this->cexSavedmodeshipRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($results as $item) {
            $newIdCarrier = ';';

            foreach ($formulario as $campo) {

                $valor_idbc = $campo['value'];
                $id_carrier = $campo['name'];

                if ($item->getIdBc() == $valor_idbc) {
                    $newIdCarrier .= $id_carrier . ';';
                }
            }

            $item->setIdCarrier($newIdCarrier);
            $comprobante = $this->cexSavedmodeshipRepository->save($item);
        }

        if ($comprobante == true) {
            $mensaje = array(
                'type' => 'success',
                'title' => __('Guardar transportistas'),
                'mensaje' => __('Los datos se han actualizado correctamente'),
            );
        } else {
            $mensaje = array(
                'type' => 'error',
                'title' => __('Guardar transportistas'),
                'mensaje' => __('Los datos no se han actualizado'),
            );
        }
        $retorno = array(
            'mensaje' => $mensaje,
        );

        echo json_encode($retorno);
    }


    public function generarLogSoporte()
    {
        $fileName = $_POST['nombre'];
        $retorno = '';

        switch ($fileName) {
            case 'cex_history':
                $retorno = $this->generarSoporteBaseDatosHistory();
                break;
            case 'cex_savedships':
                $retorno = $this->generarSoporteBaseDatosSavedShips();
                break;
            case 'cex_migrations':
                $retorno = $this->generarSoporteBaseDatosMigrations();
                break;
        }
        echo $retorno;
        exit();
    }

    private function generarSoporteBaseDatosMigrations(): string
    {
        $result = '';
        $migrations = $this->cexMigrationRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($migrations as $migration) {
            $result .= "ID MIGRACION: " . $migration->getMigrationId() . "\n";
            $result .= "\tNOMBRE MIGRACION: " . $migration->getMetodoEjecutado() . "\n";
            $result .= "\tFECHA CREACIÓN: " . $migration->getCreatedAt() . "\n";
            $result .= "________________________________________________________________________________________________________________________________\n\n";
        }
        return $result;

    }

    private function generarSoporteBaseDatosSavedShips(): string
    {
        $result = '';
        $sortOrder = $this->sortOrderBuilder
            ->setField('ship_id')
            ->setDirection('DESC')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('type', 'envio')
            ->setPageSize(25)
            ->setSortOrders([$sortOrder])
            ->create();

        $savedships = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($savedships as $savedship) {
            $oficina_entrega = '';
            if (strcmp($savedship["oficina_entrega"], '') != 0) {
                $oficina_entrega = str_replace('#!#', '*!*', $savedship->getOficinaEntrega());
            }
            $result .= "ID ENVIO: " . $savedship->getSavedShipsId() . "\n";
            $result .= "\tID ORDEN: " . $savedship->getIdOrder() . "\n";
            $result .= "\tREFERENCIA ENVÍO: " . $savedship->getNumCollect() . "\n";
            $result .= "\tTIPO:  " . $savedship->getType() . "\n";
            $result .= "\tNÚMERO DE ENVÍO:  " . $savedship->getNumShip() . "\n";
            $result .= "\tID REMITENTE:  " . $savedship->getIdSender(). "\n";
            $result .= "\tREMITENTE:  " . $savedship->getCollectFrom() . "\n";
            $result .= "\tCÓDIGO POSTAL:  " . $savedship->getPostalCode() . "\n";
            $result .= "\tPESO: " . $savedship->getKg() . "\n";
            $result .= "\tBULTOS:  " . $savedship->getPackage() . "\n";
            $result .= "\tCONTRARREEMBOLSO:  " . $savedship->getPaybackVal() . "\n";
            $result .= "\tVALOR ASEGURADO:  " . $savedship->getIndsuredValue() . "\n";
            $result .= "\tCODIGO PRODUCTO:  " . $savedship->getIdBc() . "\n";
            $result .= "\tNOMBRE PRODUCTO:  " . $savedship->getModeShipName() . "\n";
            $result .= "\tESTADO:  " . $savedship->getStatus() . "\n";
            $result .= "\tISO PAIS:  " . $savedship->getIsoCode() . "\n";
            $result .= "\tDEVOLUCIÓN ??:  " . $savedship->getDevolution() . "\n";
            $result .= "\tENTREGA SABADO ??:  " . $savedship->getDeliverSat() . "\n";
            $result .= "\tDESTINATARIO:  " . $savedship->getReceiverName() . "\n";
            $result .= "\tCÓDIGO POSTAL DESTINO:  " . $savedship->getReceiverPostCode() . "\n";
            $result .= "\tCÓDIGO CLIENTE:  " . $savedship->getCodigoCliente() . "\n";
            $result .= "\tOFICINA CORREOS:  " . $oficina_entrega . "\n";
            $result .= "\tESTADO DEL ENVÍO:  " . $savedship->getWsEstadoTracking() . "\n";
            $result .= "\tCÓDIGO AT PORTUGAL:  " . $savedship->getAtPortugal() . "\n";
            $result .= "\tFECHA DE GRABACIÓN:  " . $savedship->getCreatedAt() . "\n";
            $result .= "\tBORRADO:  " . $savedship->getDeletedAt() . "\n";
            $result .= "________________________________________________________________________________________________________________________________\n\n";
        }
        return $result;
    }

    private function generarSoporteBaseDatosHistory(): string
    {
        $result = '';
        $sortOrder = $this->sortOrderBuilder
            ->setField('history_id')
            ->setDirection('DESC')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->setPageSize(25)
            ->setSortOrders([$sortOrder])
            ->create();

        $historico = $this->cexHistoryRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($historico as $his) {

            $envio_ws_formateado = str_replace('#', '', $his->getEnvioWs());

            $result .= "ID HISTÓRICO: " . $his->getHistoryId() . "\n";
            $result .= "\tID ORDEN: " . $his->getIdOrder() . "\n";
            $result .= "\tTIPO:  " . $his->getType() . "\n";
            $result .= "\tNÚMERO DE ENVÍO:  " . $his->getNumShip() . "\n";
            $result .= "\tRESULTADO:  " . $his->getResultado() . "\n";
            $result .= "\tMENSAJE ERROR WS:  " . $his->getMensajeRetorno() . "\n";
            $result .= "\tCÓDIGO DE RETORNO:  " . $his->getCodigoRetorno() . "\n";
            $result .= "\tPETICIÓN DE ENVÍO: \n\t\t " . $envio_ws_formateado . "\n";
            $result .= "\tRESPUESTA WS: \n\t\t " . $his->getRespuestaWs() . "\n";
            $result .= "\tFECHA DE GRABACIÓN:  " . $his->getFecha() . "\n";
            $result .= "\tFECHA RECOGIDA:  " . $his->getFechaRecogida() . "\n";
            $result .= "\tHORA RECOGIDA DESDE:  " . $his->getHoraRecogidaDesde() . "\n";
            $result .= "\tHORA RECOGIDA HASTA:  " . $his->getHoraRecogidaHasta() . "\n";
            $result .= "\tCÓDIGO PRODUCTO WS:  " . $his->getIdBcWs() . "\n";
            $result .= "\tNOMBRE PRODUCTO WS:  " . $his->getModeShipNameWs() . "\n\n";
            $result .= "________________________________________________________________________________________________________________________________\n\n";

        }
        return $result;
    }

}
