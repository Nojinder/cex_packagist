<?php

namespace CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Utilidades;

use CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Rest\Index as RestIndex;
use CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Helpers\Index as HelpersIndex;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Model\Order\ItemFactory;
use Magento\Shipping\Model\Config;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\sortOrderBuilder;
use Magento\Framework\Api\FilterBuilder;

//CEX
//interface factory
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedsenderInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexCustomercodeInterfaceFactory;

//Repository Interfaces
use CorreosExpress\RegistroDeEnvios\Api\CexSavedmodeshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexSavedshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexOfficedeliverycorreoRepositoryInterface;

class Ajax extends Action
{
    protected $formKey;
    protected $setup;
    protected $_resource;
    protected $cexSavedmodeshipRepository;
    protected $cexSavedsenderFactory;
    protected $cexCustomercodeFactory;
    protected $cexSavedshipRepository;
    protected $cexOfficedeliverycorreoRepository;
    protected $searchCriteriaBuilder;
    protected $filterBuilder;
    protected $sortOrderBuilder;
    protected $_cexRest;
    protected $_cexHelpers;
    protected $itemFactory;
    protected $orderCollectionFactory;


    /**
     * Create constructor.
     *
     * @param Context $context
     * @param FormKey $formKey
     * @param ModuleDataSetupInterface $setup
     * @param ResourceConnection $resource
     * @param CexSavedmodeshipRepositoryInterface $cexSavedmodeshipRepository
     * @param CexSavedsenderInterfaceFactory $cexSavedsenderFactory
     * @param CexCustomercodeInterfaceFactory $cexCustomercodeFactory
     * @param CexSavedshipRepositoryInterface $cexSavedshipRepository
     * @param CexOfficedeliverycorreoRepositoryInterface $cexOfficedeliverycorreoRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param Rest\Index $cexRest
     * @param Helpers\Index $cexHelpers
     * @param ItemFactory $itemFactory
     * @param OrderCollectionFactory $orderCollectionFactory
     */
    public function __construct(
        Context                                    $context,
        FormKey                                    $formKey,
        ModuleDataSetupInterface                   $setup,
        ResourceConnection                         $resource,
        CexSavedmodeshipRepositoryInterface        $cexSavedmodeshipRepository,
        CexSavedsenderInterfaceFactory             $cexSavedsenderFactory,
        CexCustomercodeInterfaceFactory            $cexCustomercodeFactory,
        CexSavedshipRepositoryInterface            $cexSavedshipRepository,
        CexOfficedeliverycorreoRepositoryInterface $cexOfficedeliverycorreoRepository,
        SearchCriteriaBuilder                      $searchCriteriaBuilder,
        FilterBuilder                              $filterBuilder,
        SortOrderBuilder                           $sortOrderBuilder,
        RestIndex                                  $cexRest,
        HelpersIndex                               $cexHelpers,
        ItemFactory                                $itemFactory,
        OrderCollectionFactory                     $orderCollectionFactory)
    {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->setup = $setup;
        $this->_resource = $resource;
        $this->cexSavedmodeshipRepository = $cexSavedmodeshipRepository;
        $this->cexSavedsenderFactory = $cexSavedsenderFactory;
        $this->cexCustomercodeFactory = $cexCustomercodeFactory;
        $this->cexSavedshipRepository = $cexSavedshipRepository;
        $this->cexOfficedeliverycorreoRepository = $cexOfficedeliverycorreoRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->_cexRest = $cexRest;
        $this->_cexHelpers = $cexHelpers;
        $this->itemFactory = $itemFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * Load the page defined in view/adminhtml/layout/correosexpress_utilidades_index.xml
     *
     * @return Page
     */
    public function execute()
    {
        $post = $this->getRequest()->getPost();

        if (isset($post['action']) && !empty($post['action'])) {
            $func = $post['action'];
            call_user_func(array($this, $func));
        }
    }

    public function getInitUtilidades()
    {

        $retorno = array(
            'etiquetaDefecto' => $this->retornarEtiqueta(),
            'tipoCron' => $this->_cexHelpers->getCustomerOptionsClave('MXPS_CRONTYPE')
        );

        echo $this->_cexHelpers->getJsonEncode($retorno);
    }

    private function retornarEtiqueta()
    {
        return $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTPDF');
    }

    public function obtenerPedidosBusqueda()
    {

        $post = $this->getRequest()->getPost();
        $opciones = $this->_cexHelpers->getCustomerOptions();
        $bultos = $opciones['MXPS_DEFAULTBUL'];
        $fechadesde = explode('/', $post['desde']);
        $fechahasta = explode('/', $post['hasta']);

        $desde = date_create($fechadesde[2] . '-' . $fechadesde[1] . '-' . $fechadesde[0]);
        $desde = date_format($desde, 'Y-m-d H:i:s');

        $hastaF = date('Y-m-d', strtotime($fechahasta[2] . '-' . $fechahasta[1] . '-' . $fechahasta[0]));
        $hasta = date("Y-m-d H:i:s", strtotime($hastaF . "+ 1 days"));

        $table1=$this->_resource->getTableName('sales_order');
        $table2=$this->_resource->getTableName('correosexpress_registrodeenvios_cexsavedships');

        $query = "SELECT IFNULL(num_ship,'') as num_ship, IFNULL(num_collect,'') as num_collect, p.entity_id
                                        FROM $table1 p
                                        LEFT JOIN (SELECT *
                                                        FROM $table2
                                                        WHERE type != 'Recogida'
                                                        AND deleted_at is null) s
                                        ON p.entity_id = s.id_order
                                        WHERE p.created_at >=  '$desde'
                                        AND p.created_at <= '$hasta'";

        $readConnection = $this->_resource->getConnection('core_read');
        $ordenes = $readConnection->fetchAll($query);

        $retorno = array();

        foreach ($ordenes as $orden) {
            $id = intval($orden['entity_id']);
            $datosOrden = $this->obtenerDatosOrdenCEXById($id);

            $aux = array(
                'idOrden' => $id,
                'estado' => $datosOrden['estado'],
                'cliente' => $datosOrden['cliente'],
                'fecha' => $datosOrden['fecha'],
                'bultos' => $bultos,
                'codigoOficina' => $datosOrden['text_oficina'],
                'numeroEnvio' => $orden['num_ship'],
                'numCollect' => $orden['num_collect'],
                'selectProductos' => $this->cexRetornarSelectProductosEnvioOrden($id),
                'carrierProducto' => $datosOrden['carrier_title'] . ' - ' . $datosOrden['name']

            );
            $retorno[] = $aux;
        }

        echo json_encode($retorno);
        exit;
    }

    public function buscarPedido()
    {
        $post = $this->getRequest()->getPost();
        $fecha_explode = explode('/', $post['fecha']);

        $createdAtMin = date_create($fecha_explode[2] . '-' . $fecha_explode[1] . '-' . $fecha_explode[0]);
        $createdAtMin = date_format($createdAtMin, 'Y-m-d H:i:s');

        $createdAtMax = date_create($fecha_explode[2] . '-' . $fecha_explode[1] . '-' . $fecha_explode[0]);
        date_add($createdAtMax, date_interval_create_from_date_string('1 days'));
        $createdAtMax = date_format($createdAtMax, 'Y-m-d H:i:s');

        $retorno = array();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('created_at', $createdAtMax , 'lteq')
            ->addFilter('created_at', $createdAtMin , 'gteq')
            ->addFilter('type', 'Envio')
            ->addFilter('deleted_at','','null')
            ->create();

        $ordenes = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($ordenes as $orden) {
            $fecha = date('d-m-Y', strtotime($orden->getCreatedAt()));
            $aux = array(
                'idOrden' => $orden->getIdOrder(),
                'numCollect' => $orden->getNumCollect(),
                'numShip' => $orden->getNumShip(),
                'NombreDestinatario' => $orden->getReceiverName(),
                'direccionDestino' => $orden->getReceiverAddress(),
                'fecha' => $fecha,
                'dias' => $this->diasDiferencia($fecha)
            );

            $retorno[] = $aux;
        }

        echo json_encode($retorno);
        exit;
    }

    private function diasDiferencia($fechaCreacion)
    {
        $dias = (strtotime(date('d-m-Y')) - strtotime($fechaCreacion)) / 86400;
        return abs($dias);
    }

    private function cexRetornarSelectProductosEnvioOrden($id_orden): string
    {

        $datosOrden = $this->obtenerDatosOrdenCEXById($id_orden);

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('checked', '1')
            ->create();

        $productos = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        $name = $id_orden;
        $id = ';' . $datosOrden['carrier'] . ';';

        if (sizeof($productos) == 0) {
            $select = " <select id='nombreProductos' name='$name' class='form-control rounded-left-0 rounded-right' disabled>
            <option value=' '>" . 'No hay productos CEX activos' . "</option></select>";

        } else {
            $cabecera = "<select id='nombreProductos' name='$name' class='form-control rounded-left-0 rounded-right'>";
            $contenido = '';
            $contenido .= " <option value='0'>" . 'No corresponde a productos CEX' . "</option>";

            foreach ($productos as $result) {
                $nombreProducto = $result->getName();
                $id_bc = $result->getIdBc();

                if (is_numeric(strpos($result->getIdCarrier(), $id)) !== false) {
                    $contenido .= " <option value='$id_bc' selected >" . $nombreProducto . "</option>";
                } else {
                    $contenido .= " <option value='$id_bc'>" . $nombreProducto . "</option>";
                }
            }
            $footer = "</select>";
            $select = $cabecera . $contenido . $footer;

        }

        return $select;
    }

    public function obtenerDatosOrdenCEXById($id_orden, $productoPost = false)
    {
        $orderCollection = $this->orderCollectionFactory
            ->create();

        $orderCollection->getSelect()
            ->joinLeft(
                ['soa' => $this->_resource->getTableName('sales_order_address')],
                'main_table.entity_id = soa.parent_id',
                []
            )->joinLeft(
                ['qsr' => $this->_resource->getTableName('quote_shipping_rate')],
                'qsr.address_id = soa.quote_address_id',
                ['qsr.method','qsr.carrier','qsr.carrier_title']
            )
            ->where('main_table.entity_id = ' . $id_orden)
            ->where('qsr.code =  main_table.shipping_method');

        $order              = $orderCollection->getData();
        $order              = reset($order);
        $transportista      = $order['method'];

        if (empty($productoPost)) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('id_carrier', '%;' . $transportista . ';%', 'like')
                ->create();
        } else {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('id_bc', $productoPost)
                ->create();
        }

        $metodos = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        if (!empty($metodos)) {
            $metodos = reset($metodos);
        } else {
            $metodos['id_bc']       = "";
            $metodos['name']        = "Not Mapped";
        }

        $metodos['entrega_oficina']     = false;
        $metodos['codigo_oficina']      = '';
        $metodos['text_oficina']        = '';
        $metodos['id_orden']            = $id_orden;
        $metodos['id_carrito']          = $order['quote_id'];
        $metodos['shipping_address_id'] = $order['shipping_address_id'];
        $metodos['shipping_method']     = $order['shipping_method'];
        $metodos['carrier']             = $order['carrier'];
        $metodos['carrier_title']       = $order['carrier_title'];
        $metodos['estado']              = $order['status'];
        $metodos['cliente']             = $order['customer_lastname'] . ', ' . $order['customer_firstname'];       
        $metodos['fecha']               = date('d-m-Y', strtotime($order['created_at']));

        if ($metodos['id_bc'] == 44) {
            $metodos['entrega_oficina'] = true;
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('id_cart', intval($order['quote_id']), 'eq')
                ->create();

            $oficinas = $this->cexOfficedeliverycorreoRepository
                ->getList($searchCriteria)
                ->getItems();
            $oficinas = reset($oficinas);
            if($oficinas){
                $metodos['codigo_oficina'] = $oficinas->getCodigoOficina();
                $metodos['text_oficina'] = $oficinas->getTextoOficina();
            }            
        }
        return $metodos;
    }


    public function cexFormPedidos()
    {

        $ordenes                = $this->getRequest()->getPost('ordenes');
        $opciones               = $this->_cexHelpers->getCustomerOptions();
        $retorno                = Array();        
        $numCollectsErrores     = Array();       
        $numCollectsEtiqueta    = Array();
        $errores                = Array();

        foreach ($ordenes as $orden) {
            $referenciaCliente = $this->_cexHelpers->retornarId($orden['id']);
            $numShip = '';
            $numcollect = $referenciaCliente . 'ga';
            $datosOrden = $this->obtenerDatosRequestSavedShips($orden['id'], $numcollect, $orden['bultos'], $orden['productosCEX']);
            $tipoEtiqueta = $this->getRequest()->getPost('tipoEtiqueta');
            $posicion = $this->getRequest()->getPost('posicion');

            if (!empty($datosOrden['codigo_cliente'])) {
                $noExiste = $this->_cexHelpers->comprobarIdPedidoNumShip($numcollect, 'Envio');

                if ($noExiste === true) {
                    if(strcmp("", $datosOrden['codigo_oficina']) == 0 && $datosOrden['entrega_oficina'] == 'true'){
                        $error = $this->_cexHelpers->crearError($orden['id'], $numcollect, __('No hay oficina seleccionada, vaya a la orden y escoja una'), '-2');
                        array_push($errores, $error);
                        array_push($numCollectsErrores,$numcollect);
                    }else{
                        $type = 'Envio';
                        $this->_cexHelpers->cexGuardarSavedships($datosOrden, $numShip, $type);
                        $rest = $this->_cexRest->enviarPeticionEnvioRestCex($datosOrden);
                        $retorno = $this->_cexRest->procesarCurl($rest);
                        $respuesta_envio = $this->_cexRest->procesarPeticionEnvioRestCex($rest['peticion'], $retorno, intval($orden['id']), $type, $numcollect);
    
                        unset($respuesta_envio['etiqueta']);
    
                        $body = json_decode($retorno['body']);
    
                        if ($retorno['status_code'] != 200 || $body->codigoRetorno != 0) {
                            $error = $this->_cexHelpers->crearError($respuesta_envio['id_order'], $numcollect, $respuesta_envio['mensajeRetorno'], '-2');
                            array_push($errores, $error);
                            array_push($numCollectsErrores,$numcollect);
                        } else {
                            $this->_cexHelpers->cexGuardarSavedships($datosOrden, $respuesta_envio['numShip'], $type);
                            if ($opciones['MXPS_SAVEDSTATUS'] == 'true') {
                                $this->_cexHelpers->cambiarEstadoOrder($orden['id'], $opciones['MXPS_RECORDSTATUS']);
                            }
                            array_push($numCollectsEtiqueta,$numcollect);
                        }
                        switch ($datosOrden['modificacionAutomatica']) {
                            case 1:
                                $error = $this->_cexHelpers->crearError($orden['id'], $numcollect, __('Modificada relación transportista, se asigna PAQ 24'), '-2');
                                array_push($errores, $error);
                                array_push($numCollectsErrores,$numcollect);
                                break;
                            case 2:
                                $error = $this->_cexHelpers->crearError($orden['id'], $numcollect, __('Modificados productos configurados, se asigna y añade PAQ 24'), '-2');
                                array_push($errores, $error);
                                array_push($numCollectsErrores,$numcollect);
                                break;
                            default:
                                break;
                        }
                    }
                } else {
                    $error = $this->_cexHelpers->crearError($orden['id'], $numcollect, __('El envío ya está grabado, reimprima la etiqueta en la sección de Reimpresión'), 1);
                    array_push($errores, $error);
                }

            } else {
                $error = $this->_cexHelpers->crearError($orden['id'], $numcollect, __('Error no hay guardado ningún remitente por defecto'), 1);
                array_push($errores, $error);
            }

        }


        if(count($numCollectsErrores) != 0){
            $this->_cexHelpers->deleteMultipleSavedShips($numCollectsErrores);
        }

        if(count($numCollectsEtiqueta) != 0){
            $retorno = $this->cexGenerarEtiquetas($numCollectsEtiqueta, $tipoEtiqueta, $posicion, 1,$errores);               
            echo json_encode($retorno);        
            exit;
        }else{
            $retorno = array(
                'errores'   => $this->_cexHelpers->pintarErroresMasiva($errores, 'erroresMasiva', 1),
                'etiquetas' => false
            );
            echo json_encode($retorno);        
            exit;
        }
    }

    private function obtenerDatosRequestSavedShips($idOrder, $numcollect, $bultos, $productoPost): array
    {
        $metodoEnvio = $this->obtenerDatosOrdenCEXById($idOrder, $productoPost);
        $referenciaCliente = $this->_cexHelpers->retornarId($idOrder);

        $order = $this->_cexHelpers->retornarOrdenById($referenciaCliente);

        $opciones = $this->_cexHelpers->getCustomerOptions();
        $datosEnvio = $order->getShippingAddress()->getData();
        $datosRemitenteDefecto = $this->obtenerDatosRemitenteDefecto($opciones['MXPS_DEFAULTSEND']);

        $contrarembolso = $this->comprobarPayBack($idOrder);
        $peso = $this->retornarPesoOrden($opciones['MXPS_ENABLEWEIGHT'], $order['entity_id']);

        $aux = array(
            'id' => $idOrder,
            // primera columna
            'loadSender' => $datosRemitenteDefecto['sender_id'],
            'name_sender' => $datosRemitenteDefecto['name'],
            'contact_sender' => $datosRemitenteDefecto['contact'],
            'address_sender' => $datosRemitenteDefecto['address'],
            'postcode_sender' => $datosRemitenteDefecto['postcode'],
            'city_sender' => $datosRemitenteDefecto['city'],
            'country_sender' => $this->_cexHelpers->getCountryByIsoCode($datosRemitenteDefecto['iso_code_pais']),
            'iso_code_remitente' => $datosRemitenteDefecto['iso_code_pais'],
            'phone_sender' => $datosRemitenteDefecto['phone'],
            'email_sender' => $datosRemitenteDefecto['email'],
            'grabar_recogida' => 'false',
            'note_collect' => '',
            // segunda columna
            'loadReceiver' => 'false',
            'name_receiver' => $datosEnvio['firstname'] . ' ' . $datosEnvio['lastname'],
            'contact_receiver' => $datosEnvio['firstname'] . ' ' . $datosEnvio['lastname'],
            'address_receiver' => $datosEnvio['street'],
            'postcode_receiver' => $datosEnvio['postcode'],
            'city_receiver' => $datosEnvio['city'],
            'phone_receiver1' => $datosEnvio['telephone'],
            'phone_receiver2' => $datosEnvio['telephone'],
            'email_receiver' => $datosEnvio['email'],
            'country_receiver' => $datosEnvio['country_id'],
            'note_deliver' => '',
            // tercera columna
            'id_codigo_cliente' => $datosRemitenteDefecto['id_codigo_cliente'],
            'codigo_cliente' => $datosRemitenteDefecto['codigo_cliente'],
            'codigo_solicitante' => $datosRemitenteDefecto['codigo_solicitante'],
            'datepicker' => date("Y-m-d"),
            'fromHH_sender' => ($datosRemitenteDefecto['from_hour'] <= 9) ? '0' . $datosRemitenteDefecto['from_hour'] : $datosRemitenteDefecto['from_hour'],
            'fromMM_sender' => ($datosRemitenteDefecto['from_minute'] <= 9) ? '0' . $datosRemitenteDefecto['from_minute'] : $datosRemitenteDefecto['from_minute'],
            'toHH_sender' => ($datosRemitenteDefecto['to_hour'] <= 9) ? '0' . $datosRemitenteDefecto['to_hour'] : $datosRemitenteDefecto['to_hour'],
            'toMM_sender' => ($datosRemitenteDefecto['to_minute'] <= 9) ? '0' . $datosRemitenteDefecto['to_minute'] : $datosRemitenteDefecto['to_minute'],
            'ref_ship' => $numcollect,
            'desc_ref_1' => '',
            'desc_ref_2' => '',
            'selCarrier' => $metodoEnvio['id_bc'],
            'nombre_modalidad' => $metodoEnvio['name'],
            'deliver_sat' => '',
            'iso_code' => $datosEnvio['country_id'],
            'entrega_oficina' => $metodoEnvio['entrega_oficina'],
            'codigo_oficina' => $metodoEnvio['codigo_oficina'],
            'text_oficina' => $metodoEnvio['text_oficina'],
            'payback_val' => ($contrarembolso) ? number_format($order['grand_total'], 2) : '',
            'insured_value' => '',
            'bultos' => $bultos,
            'kilos' => $peso,
            'modificacionAutomatica' => '',
            'tipoEtiqueta' => $this->getRequest()->getPost('tipoEtiqueta'),
            'posicionEtiqueta' => $this->getRequest()->getPost('posicion'),
            'at_portugal' => null
        );

        return $aux;

    }

    private function obtenerDatosRemitenteDefecto($id_rem_def)
    {

        $savedSenderModel = $this->cexSavedsenderFactory->create();
        $datosRemitenteDefecto = $savedSenderModel->getCollection()
            ->addFilter('sender_id', $id_rem_def)
            ->getData();
        if (!empty($datosRemitenteDefecto[0])) {
            $datosRemitenteDefecto = $datosRemitenteDefecto[0];

            $customerCodeModel = $this->cexCustomercodeFactory->create();
            $codigosCliente = $customerCodeModel->getCollection()
                ->addFilter('customer_code_id', $datosRemitenteDefecto['id_cod_cliente'])
                ->getData();

            $codigosCliente = $codigosCliente[0];

            $datosRemitenteDefecto['id_codigo_cliente'] = $codigosCliente['customer_code_id'];
            $datosRemitenteDefecto['codigo_cliente'] = $codigosCliente['customer_code'];
            $datosRemitenteDefecto['codigo_solicitante'] = $codigosCliente['code_demand'];
        } else {
            $datosRemitenteDefecto = null;
        }

        return $datosRemitenteDefecto;
    }

    private function comprobarPayBack($idOrden): bool
    {
        $id = $this->_cexHelpers->retornarId($idOrden);
        $order = $this->_cexHelpers->retornarOrdenById($id);
        $payment = $order->getPayment()->getMethod();
        return strcmp('cashondelivery', $payment) == 0;
    }

    private function cexGenerarEtiquetas($numCollect = false, $tipoEtiqueta = false, $posicion = false, $tipoReimpresion = false,$erroresGrabacion = Array())
    {
        if (!$numCollect) {
            $numCollect         = $_POST['numCollect'];
            $tipoEtiqueta       = intval($_POST['tipoEtiqueta']);
            $posicion           = intval($_POST['posicion']);
            $tipoReimpresion    = intval($_POST['tipoReimpresion']);
        }

        $rest       = $this->_cexRest->cexEnviarPeticionReimpresion($numCollect, $tipoEtiqueta, $posicion);
        $curl       = $this->_cexRest->cexProcesarCurlReimpresion($rest);
        $retorno    = $this->_cexRest->cexProcesarRespuestaReimpresion($curl, $tipoReimpresion, $numCollect,$erroresGrabacion);

        echo json_encode($retorno);
        exit;
    }

    public function buscarResumen(){
        $fecha_explode = explode('-',$this->getRequest()->getPost('fecha'));

        $createdAtMin = date_create($fecha_explode[2] . '-' . $fecha_explode[1] . '-' . $fecha_explode[0]);
        $createdAtMin = date_format($createdAtMin, 'Y-m-d H:i:s');

        $createdAtMax = date_create($fecha_explode[2] . '-' . $fecha_explode[1] . '-' . $fecha_explode[0]);
        date_add($createdAtMax, date_interval_create_from_date_string('1 days'));
        $createdAtMax = date_format($createdAtMax, 'Y-m-d H:i:s');

        $retorno = array();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('created_at', $createdAtMax , 'lteq')
            ->addFilter('created_at', $createdAtMin , 'gteq')
            ->addFilter('type', 'Envio')
            ->addFilter('deleted_at','','null')
            ->create();

        $ordenes = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($ordenes as $orden) {
            
            $aux = array(
                'idOrden'                   => $orden->getIdOrder(),
                'numCollect'                => $orden->getNumCollect(),
                'numShip'                   => $orden->getNumShip(),
                'NombreDestinatario'        => $orden->getReceiverName(),
                'direccionDestino'          => $orden->getReceiverAddress(),
                'fecha'                     => date('d-m-Y',strtotime($orden->getUpdatedAt())),
            );
            $retorno[] = $aux;
        }
       echo json_encode($retorno);
    }

    public function generarResumen(){
        $retorno = [];
        $numCollect     = $this->getRequest()->getPost('numCollect');
        $rest           = $this->_cexRest->cexEnviarPeticionResumen($numCollect);
        $curl           = $this->_cexRest->cexProcesarCurlResumen($rest);
        $retorno        = $this->_cexRest->cexProcesarRespuestaResumen($curl);

        echo json_encode($retorno);
        exit;
    }

    public function obtenerIdioma()
    {
        $idioma = $this->_cexHelpers->obtenerIdiomaUsuario();
        echo $idioma;
    }

    public function retornarPesoOrden($data, $idOrder)
    {
        if ($data == "true") {
            $peso = $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTKG');
        } else {
            $orderCollection    = $this->orderCollectionFactory->create();
            $select             = $orderCollection->getSelect();
            $select->where('main_table.quote_id = ' . $idOrder);

            $OrderItem          = $orderCollection->getData();
            $OrderItem = reset($OrderItem);
            $peso = $OrderItem['weight'];
        }

        return $peso;
    }

    public function ejecutarCron()
    {
        $this->_cexHelpers->comprobarCronAjax();
    }
}
