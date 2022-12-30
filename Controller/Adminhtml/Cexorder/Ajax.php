<?php

namespace CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Cexorder;

use CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Rest;
use CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Helpers;
use Magento\Framework\App\Action\Action;
use Magento\Backend\App\Action\Context;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Form\FormKey;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\sortOrderBuilder;

//CEX
//Collection Factory
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexCustomercode\CollectionFactory as CustomerCodeCollectionFactory;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedship\CollectionFactory as SavedShipCollectionFactory;

//Repository Interfaces
use CorreosExpress\RegistroDeEnvios\Api\CexSavedmodeshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexSavedsenderRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexSavedshipRepositoryInterface;

/**
 * Class Ajax
 */
class Ajax extends Action
{
    protected $formKey;
    protected $_resource;
    protected $cexSavedmodeshipRepository;
    protected $cexSavedsenderRepository;
    protected $cexCustomercodeCollectionFactory;
    protected $cexSavedshipCollectionFactory;
    protected $cexSavedshipRepository;
    protected $searchCriteriaBuilder;
    protected $sortOrderBuilder;
    protected $_cexRest;
    protected $_cexHelpers;
    protected $_countryFactory;

    /**
     * Create constructor.
     *
     * @param Context $context
     * @param FormKey $formKey
     * @param ResourceConnection $resource
     * @param CexSavedmodeshipRepositoryInterface $cexSavedmodeshipRepository
     * @param CexSavedsenderRepositoryInterface $cexSavedsenderRepository
     * @param CustomerCodeCollectionFactory $cexCustomercodeCollectionFactory
     * @param CexSavedshipRepositoryInterface $cexSavedshipRepository
     * @param SavedShipCollectionFactory $cexSavedshipCollectionFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param sortOrderBuilder $sortOrderBuilder
     * @param Rest\Index $cexRest
     * @param Helpers\Index $cexHelpers
     * @param CountryFactory $countryFactory
     */
    public function __construct(
        Context                             $context,
        FormKey                             $formKey,
        ResourceConnection                  $resource,
        CexSavedmodeshipRepositoryInterface $cexSavedmodeshipRepository,
        CexSavedsenderRepositoryInterface   $cexSavedsenderRepository,
        CustomerCodeCollectionFactory       $cexCustomercodeCollectionFactory,
        CexSavedshipRepositoryInterface     $cexSavedshipRepository,
        SavedShipCollectionFactory          $cexSavedshipCollectionFactory,
        SearchCriteriaBuilder               $searchCriteriaBuilder,
        sortOrderBuilder                    $sortOrderBuilder,
        Rest\Index                          $cexRest,
        Helpers\Index                       $cexHelpers,
        CountryFactory                      $countryFactory)
    {
        $this->formKey = $formKey;
        $this->_resource = $resource;
        $this->cexSavedmodeshipRepository = $cexSavedmodeshipRepository;
        $this->cexSavedsenderRepository = $cexSavedsenderRepository;
        $this->cexCustomercodeCollectionFactory = $cexCustomercodeCollectionFactory;
        $this->cexSavedshipRepository = $cexSavedshipRepository;
        $this->cexSavedshipCollectionFactory = $cexSavedshipCollectionFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->_cexRest = $cexRest;
        $this->_cexHelpers = $cexHelpers;
        $this->_countryFactory = $countryFactory;
        parent::__construct($context);
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function execute()
    {
        $post = $this->getRequest()->getPost();

        if (isset($post['action']) && !empty($post['action'])) {
            $func = $post['action'];
            call_user_func(array($this, $func));
        }
    }

    public function getOrderId()
    {
        return $_POST['id'];
    }

    public function cexFormOrderTemplate()
    {
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $id = $this->getRequest()->getPost('id');
        } else {
            return;
        }

        $referenciaOrden = $this->_cexHelpers->retornarId($id);

        $esCex = $this->esOrdenCex($referenciaOrden);
        $retorno = array(
            'etiquetaDefecto' => $this->retornarEtiqueta(),
            'metodoEnvio' => $this->retornarMetodoEnvio($referenciaOrden),
            'selectCodCliente' => $this->retornarSelectCodigosCliente(),
            'selectRemitentes' => $this->retornarSelectRemitentes(),
            'productos' => $this->retornarSelectProductosActivos($referenciaOrden),
            'datosRemitente' => $this->recuperarRemitenteDefecto(),
            'datosEnvio' => $this->recuperarDatosEnvio($referenciaOrden),
            'selectDestinatarios' => $this->retornarSelectDestinatarios(),
            'paises' => $this->retornarPaises(),
            'contrareembolso' => $this->_cexHelpers->comprobarContrareembolso($referenciaOrden),
            'paisOrden' => $this->retornarPaisElegido(),
            'datosOficina' => $this->_cexHelpers->retornarDatosOficina($referenciaOrden),
            'peso' => $this->_cexHelpers->retornarPesoPedido($referenciaOrden),
            'referenciaOrder' => $referenciaOrden,
            'tipoCron' => $this->_cexHelpers->getCustomerOptionsClave('MXPS_CRONTYPE'),
            'esCex' => $esCex
        );

        echo $this->_cexHelpers->getJsonEncode($retorno);
    }

    private function esOrdenCex($id): bool
    {
        $retorno = false;
        $order = $this->_cexHelpers->retornarOrdenById($id);
        $metodosEnvioOrder = explode('_', $order->getShippingMethod());
        $metodosEnvioOrder = $metodosEnvioOrder[0];

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('checked', '1', 'eq')
            ->create();

        $metodosEnvioActivos = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($metodosEnvioActivos as $result) {
            if (strpos($result->getIdCarrier(), $metodosEnvioOrder) !== false) {
                $retorno = true;
            }
        }
        return $retorno;
    }

    private function retornarEtiqueta()
    {
        return $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTPDF');
    }

    private function retornarMetodoEnvio($id)
    {

        $order = $this->_cexHelpers->retornarOrdenById($id);

        $transpos = strpos($order->getShippingMethod(), '_');
        $transportista = substr($order->getShippingMethod(), 0, $transpos);

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('checked', '1', 'eq')
            ->addFilter('id_carrier', '%;' . $transportista . ';%', 'like')
            ->create();

        $modeship = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        if (!empty($modeship) && $modeship != false) {
            $modeshipIdbc = reset($modeship);
            $modeshipIdbc = $modeshipIdbc->getIdBc();
            if ($modeshipIdbc != 0) {
                return $modeshipIdbc;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    private function retornarSelectCodigosCliente()
    {
        return $this->cexCustomercodeCollectionFactory
            ->create()
            ->getData();
    }

    private function retornarSelectRemitentes(): string
    {
        $resultsSenderCollection = $this->cexSavedsenderRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        if (sizeof($resultsSenderCollection) == 0) {
            $select = " <select id='MXPS_DEFAULTSEND' name='MXPS_DEFAULTSEND' class='form-control' disabled>
                            <option disabled='disabled' selected>" . __('No hay remitentes dados de alta') . "</option>
                        </select>";
        } else {
            $remitenteDefectoId = $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTSEND');
            $cabecera = "<select id='MXPS_DEFAULTSEND' name='MXPS_DEFAULTSEND' class='form-control'>";
            $contenido = '';
            $existeRemitenteDefecto = 0;

            foreach ($resultsSenderCollection as $registroData) {
                if ($remitenteDefectoId == $registroData->getSenderId()) {
                    $contenido .= " <option value='" . $registroData->getSenderId() . "' selected>" . $registroData->getName() . "</option>";
                    $existeRemitenteDefecto = 1;
                } else {
                    $contenido .= " <option value='" . $registroData->getSenderId() . "'>" . $registroData->getName() . "</option>";
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

    private function retornarSelectProductosActivos($id): string
    {

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('checked', '1', 'eq')
            ->create();

        $results = $this->cexSavedmodeshipRepository
            ->getList($searchCriteria)
            ->getItems();

        $order = $this->_cexHelpers->retornarOrdenById($id);

        $carrier_order = $order->getShippingMethod();
        $carrier_order = ';' . $carrier_order . ';';
        if (sizeof($results) == 0) {
            $select = "<select id='select_modalidad_envio'   name='select_modalidad_envio' class='form-control' disabled>
            <option value=' '>" . __('No hay productos CEX activos') . "</option>
            </select>";
        } else {
            $cabecera = "<select id='select_modalidad_envio' name='select_modalidad_envio' class='form-control'>";
            $contenido = '';
            $productosCEX = $results;

            foreach ($productosCEX as $result) {
                if (is_numeric(strpos($result->getIdCarrier(), $carrier_order))) {
                    $contenido .= " <option value='" . $result->getIdBc() . "' selected >" . $result->getName() . "</option>";
                } else {
                    $contenido .= " <option value='" . $result->getIdBc() . "' >" . $result->getName() . "</option>";
                }
            }

            $footer = "</select>";
            $select = $cabecera . $contenido . $footer;
        }

        return $select;
    }

    private function recuperarRemitenteDefecto()
    {

        $id_remitente_defecto = $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTSEND');
        $retorno = array();

        if (!isset($id_remitente_defecto) || empty($id_remitente_defecto)) {
            return '';
        }

        $bultos_defecto = $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTBUL');

        $kg_defecto = $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTKG');

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('sender_id', $id_remitente_defecto, 'eq')
            ->create();

        $remitente = $this->cexSavedsenderRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($remitente as $remitenteOrder) {
            $country = $this->_countryFactory->create()->loadByCode($remitenteOrder->getIsoCodePais());
            $countryName = $country->getName();
            $retorno = array(
                'name' => $remitenteOrder->getName(),
                'contact' => $remitenteOrder->getContact(),
                'address' => $remitenteOrder->getAddress(),
                'city' => $remitenteOrder->getCity(),
                'postcode' => $remitenteOrder->getPostCode(),
                'email' => $remitenteOrder->getEmail(),
                'phone' => $remitenteOrder->getPhone(),
                'from_hour' => str_pad($remitenteOrder->getFromHour(), 2, '0', STR_PAD_LEFT),
                'from_minute' => str_pad($remitenteOrder->getFromMinute(), 2, '0', STR_PAD_LEFT),
                'to_hour' => str_pad($remitenteOrder->getToHour(), 2, '0', STR_PAD_LEFT),
                'to_minute' => str_pad($remitenteOrder->getToMinute(), 2, '0', STR_PAD_LEFT),
                'id_sender' => $remitenteOrder->getSenderId(),
                'id_customer_code' => $remitenteOrder->getIdCodCliente(),
                'bultos_defecto' => $bultos_defecto,
                'kg_defecto' => $kg_defecto,
                'iso_code' => $remitenteOrder->getIsoCodePais(),
                'selectpais' => '<option value="' . $remitenteOrder->getIsoCodePais() . '">' . $countryName . '</option>'
            );
        }
        return $retorno;
    }

    private function recuperarDatosEnvio($id): array
    {
        $mensaje = '';
        $order = $this->_cexHelpers->retornarOrdenById($id);

        $checkObservation = $this->_cexHelpers->getCustomerOptionsClave('MXPS_OBSERVATIONS');

        $delivery_address = $order->getShippingAddress()->getData();

        if ($checkObservation == "true") {
            $history = $order->getStatusHistoryCollection()->getLastItem();
            $mensaje = $history->getComment();
        }

        if ($mensaje != '' && (strpos($mensaje, 'Order changes to')) === false) {
            $nota = $mensaje;
        } else {
            $nota = '';
        }

        $nota = html_entity_decode($nota);
        $company = $delivery_address['company'];

        if ($company == '') {
            $company = $delivery_address['firstname'] . ' ' . $delivery_address['lastname'];

        }

        $address2 = $order->getShippingAddress()->getStreet2();
        $address = str_replace("\n", ' ', $delivery_address['street']);
        return array(
            'first_name' => trim($delivery_address['firstname']),
            'last_name' => trim($delivery_address['lastname']),
            'company' => trim($company),
            'address' => $address,
            'address2' => trim((String)$address2),
            'city' => trim($delivery_address['city']),
            'postcode' => trim($delivery_address['postcode']),
            'country' => trim($delivery_address['country_id']),
            'telf' => trim($delivery_address['telephone']),
            'email' => trim($delivery_address['email']),
            'customer_message' => substr($nota, 0, 70)
        );
    }

    private function retornarSelectDestinatarios(): string
    {
        $destinatarioDefecto = $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTDELIVER');

        if ($destinatarioDefecto == 'FACTURACION') {
            $retorno = "  <option value='FACTURACION' selected >" . __('Facturacion') . "</option>";
            $retorno .= "  <option value='ENVIO'>" . __('Envio') . "</option>";
        } else {
            $retorno = "  <option value='FACTURACION'  >" . __('Facturacion') . "</option>";
            $retorno .= "  <option value='ENVIO' selected>" . __('Envio') . "</option>";
        }
        return $retorno;
    }

    private function retornarPaises(): string
    {
        $countryList = $this->_countryFactory->create()->getResourceCollection()
            ->loadByStore()
            ->toOptionArray(true);

        $retorno = '';
        foreach ($countryList as $country) {
            if ($country['value'] != '') {
                $retorno .= "<option value='" . $country['value'] . "' >" . $country['label'] . "</option>";
            }
        }

        return $retorno;
    }

    private function retornarPaisElegido(): string
    {
        $id_remitente_defecto = $this->_cexHelpers->getCustomerOptionsClave('MXPS_DEFAULTSEND');

        if (!isset($id_remitente_defecto) || empty($id_remitente_defecto)) {
            return '';
        }

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('sender_id', $id_remitente_defecto, 'eq')
            ->create();

        $remitente = $this->cexSavedsenderRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($remitente as $remitenteOrder) {
            $retorno = $remitenteOrder->getIsoCodePais();
        }
        return $retorno;

    }

    public function retornarRemitente()
    {

        $resultsSenderCollection = $this->cexSavedsenderRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($resultsSenderCollection as $item) {
            $row = $item->getData();
            if ($row['sender_id'] == $this->getRequest()->getPost('id')) {
                $country = $this->_countryFactory->create()->loadByCode($row['iso_code_pais']);
                $countryName = $country->getName();
                $retorno = array(
                    'name'                =>$row['name'],
                    'contact'             =>$row['contact'],
                    'address'             =>$row['address'],
                    'city'                =>$row['city'],
                    'postcode'            =>$row['postcode'],
                    'email'               =>$row['email'],
                    'id_cod_cliente'      =>$row['id_cod_cliente'],
                    'phone'               =>$row['phone'],
                    'from_hour'           =>str_pad($row['from_hour'], 2, '0', STR_PAD_LEFT),
                    'from_minute'         =>str_pad($row['from_minute'], 2, '0', STR_PAD_LEFT),
                    'to_hour'             =>str_pad($row['to_hour'], 2, '0', STR_PAD_LEFT),
                    'to_minute'           =>str_pad($row['to_minute'], 2, '0', STR_PAD_LEFT),
                    'id_cod_code'         =>$row['id_cod_cliente'],
                    'iso_code'            =>$row['iso_code_pais'],
                    'selectpais'          =>'<option value="'.$row['iso_code_pais'].'">'.$countryName.'</option>'
                );
                $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);
                $this->getResponse()->setHeader('Access-Control-Allow-Origin', '*', true);
                $this->getResponse()->setBody($this->_cexHelpers->getJsonEncode($retorno));
            }
        }
    }

    public function retornarSavedshipsOrden()
    {

        if (isset($_POST['id']) && $_POST['id'] != '') {
            $id = $_POST['id'];
        } else {
            $id = false;
        }

        $savedShipsCollection = $this->cexSavedshipCollectionFactory
            ->create();

        $savedShipsCollection->getSelect()
            ->joinLeft(
                ['hist' => $this->_resource->getTableName('correosexpress_registrodeenvios_cexhistory')],
                'main_table.num_ship = hist.num_ship AND main_table.num_collect = hist.num_collect AND (hist.type = "Envio" OR hist.type = "Recogida")',
                ['fecha_recogida', 'hora_recogida_desde', 'hora_recogida_hasta']
            )
            ->where('main_table.id_order = ' . $id)
            ->where('main_table.deleted_at IS NULL')
            ->order('main_table.created_at DESC');

        $historicos = $savedShipsCollection->getData();

        $retorno = '<thead><tr>';
        $retorno .= '<th>' . __('Seguimiento') . '</th>';
        $retorno .= '<th>' . __('Fecha') . '</th>';
        $retorno .= '<th>' . __('Ref.Pedido') . '</th>';
        $retorno .= '<th>' . __('Tipo') . '</th>';
        $retorno .= '<th>' . __('Identificador') . '</th>';
        $retorno .= '<th>' . __('Recogida desde') . '</th>';
        $retorno .= '<th>' . __('Fecha de Recogida') . '</th>';
        $retorno .= '<th>' . __('Hora Recogida desde') . '</th>';
        $retorno .= '<th>' . __('Hora Recogida hasta') . '</th>';
        $retorno .= '<th>' . __('Estado') . '</th>';
        $retorno .= '<th>' . __('Acciones') . '</th>';
        $retorno .= '</tr></thead>';

        $footer = '<tfoot><tr>'
            . '<th>' . __('Seguimiento') . '</th>'
            . '<th>' . __('Fecha') . '</th>'
            . '<th>' . __('Ref.Pedido') . '</th>'
            . '<th>' . __('Tipo') . '</th>'
            . '<th>' . __('Identificador') . '</th>'
            . '<th>' . __('Recogida desde') . '</th>'
            . '<th>' . __('Fecha de Recogida') . '</th>'
            . '<th>' . __('Hora Recogida desde') . '</th>'
            . '<th>' . __('Hora Recogida hasta') . '</th>'
            . '<th>' . __('Estado') . '</th>'
            . '<th>' . __('Acciones') . '</th>'
            . '</tr></tfoot>';
        $retorno .= '<tbody>';
        if ($historicos) {
            foreach ($historicos as $historico) {
                if ($historico['fecha_recogida'] == '0000-00-00') {
                    $historico['hora_recogida'] = null;
                    $historico['hora_recogida_desde'] = null;
                    $historico['hora_recogida_hasta'] = null;
                }

                if (($historico['num_ship'] == "Automatica") || ($historico['num_ship'] == "Automatico")) {
                    $enlace = $historico['num_ship'];
                } else {
                    $enlace = '<div id="introjsIdentificador"><a href="https://s.correosexpress.com/c?n=' . $historico['num_ship'] . '" target="blank">' . $historico['num_ship'] . '</a></div>';
                }

                $row = '<tr>';
                $row .= '<td id="tablaHijo">
                            <span id="introjsCheckEnvios">
                                <input type="checkbox" id="' . $historico['num_collect'] . '" value="' . $historico['num_collect'] . '" class="marcarEtiquetas form-control my-auto before">
                            </span>
                                <a href="https://s.correosexpress.com/c?n=' . $historico['num_ship'] . '" target="blank">Correos Express</a></td>';
                $row .= '<td>' . $historico['date'] . '</td>';
                $row .= '<td>' . $historico['num_collect'] . '</td>';
                $row .= '<td>' . $historico['type'] . '</td>';
                $row .= '<td>' . $enlace . '</td>';
                $row .= '<td>' . $historico['collect_from'] . '</td>';
                $row .= '<td>' . $historico['fecha_recogida'] . '</td>';
                $row .= '<td>' . $historico['hora_recogida_desde'] . '</td>';
                $row .= '<td>' . $historico['hora_recogida_hasta'] . '</td>';
                $row .= '<td>' . $historico['status'] . '</td>';
                $row .= '<td><span id="introjsIconoReimprimir"><a href="#" data-toggle="tooltip" data-placement="left" title="Reprint" class="ml-3" onclick="generarEtiquetasReimpresionOrder(' . "'" . $historico['num_collect'] . "', event " . ')"><i class="fa fa-print"></i></a></span><span id="introjsIconoBorrarEnvio"><a href="#" data-toggle="tooltip" data-placement="right" title="Delete" class="ml-3" onclick="borrarPeticionEnvio(' . "'" . $historico['num_ship'] . "', '" . $historico['num_collect'] . "'" . ')"><i class="fa fa-trash"></i></a></span></td>';
                $row .= '</tr>';
                $retorno .= $row;

            }
        }
        $retorno .= '</tbody>' . $footer;

        if (empty($historicos)) {
            $retorno = "";
        }

        echo $this->_cexHelpers->getJsonEncode($retorno);
        exit;
    }

    public function retornarPrecioPedido()
    {
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $idOrden = intval($_POST['id']);
            $id = $this->_cexHelpers->retornarId($idOrden);
            $orderObj = $this->_cexHelpers->retornarOrdenById($id);
            $order = $orderObj->getData();
            $precio = $order['grand_total'];
            $precio = round($precio, 2);
        } else {
            $precio = false;
        }

        echo $precio;
        exit;
    }

    public function cexFormPedido()
    {

        $opciones = $this->_cexHelpers->getCustomerOptions();
        $request = $_REQUEST;

        $numcollect = $request['ref_ship'];

        $numship = '';
        if ($this->_cexHelpers->comprobarIdpedidoNumShip($numcollect, 'Envio')) {
            $type = 'Envio';
            $this->_cexHelpers->cexGuardarSavedships($request, $numship, $type);
            
            $rest = $this->_cexRest->enviarPeticionEnvioRestCex($request);

            $retorno = $this->_cexRest->procesarCurl($rest);

            $respuesta_envio = $this->_cexRest->procesarPeticionEnvioRestCex($rest['peticion'], $retorno, intval($request['id']), $type, $numcollect);
            $this->_cexHelpers->cexGuardarSavedships($request, $respuesta_envio['numShip'], $type);
            if ($respuesta_envio['numRecogida'] != '') {
                $this->_cexHelpers->cexGuardarSavedships($request, $respuesta_envio['numRecogida'], 'Recogida');
            } else {
                $this->_cexHelpers->cexGuardarSavedships($request, "Recogida Erronea", 'Recogida');
            }

            if (empty($respuesta_envio['numShip']) && $respuesta_envio['numShip'] = NULL) {
                $this->_cexHelpers->deleteSavedShip($numcollect);
                $respuesta_envio['resultado'] = 0;
            }
        } else {
            $respuesta_envio = array(
                'mensajeRetorno' => __('Error [PSDBE] al guardar el envío, referencia duplicada en la BD [SAVED]. Cambie la referencia y vuelva a intentarlo '),
                'numShip' => '',
                'resultado' => '0',
            );
        }

        if ($opciones['MXPS_SAVEDSTATUS'] == 'true') {
            $estado = $this->_cexHelpers->getCustomerOptionsClave('MXPS_RECORDSTATUS');
            $this->_cexHelpers->cambiarEstadoOrder(intval($request['id']), $estado);
        }

        echo $this->_cexHelpers->getJsonEncode($respuesta_envio);
        exit;
    }

    public function deleteSoftSavedShip()
    {
        $retorno = "";
        $num_ship = $_POST['num_ship'];

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('num_ship', $num_ship)
            ->create();

        $results = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        $historicos = reset($results);

        $tipo = $historicos->getType();
        $codigo_cliente = $historicos->getCodigoCliente();

        if (strcmp($tipo, "Recogida") == 0) {
            $rest = $this->_cexRest->enviarPeticionBorradoRecogida($num_ship, $codigo_cliente);
            $curl = $this->_cexRest->procesarCurl($rest);
            $this->_cexRest->procesarPeticionBorrado($curl['output'], $num_ship, $tipo);
        } else {
            $retorno = [
                'mensaje' => __('El envío ') . $num_ship . __('ha sido borrado correctamente')
            ];
        }

        if (strcmp($retorno['codigoError'], "0") == 0 || strcmp($tipo, "Envio") == 0) {
            $this->_cexHelpers->deleteSavedShipByNumShip($num_ship);
        }

        echo $this->_cexHelpers->getJsonEncode($retorno);
        exit;

    }

    public function cexFormPedidoBorrar()
    {
        $num_collect = $_POST['num_collect'];
        $num_ship = $_POST['num_ship'];
        $retorno = $this->_cexRest->gestionarBorradoPedido($num_ship, $num_collect);
        echo $this->_cexHelpers->getJsonEncode($retorno);
        exit;
    }

    public function obtenerIdioma()
    {
        $idioma = $this->_cexHelpers->obtenerIdiomaUsuario();
        echo $idioma;
    }

    public function procesarCurlOficinaRest()
    {

        $credenciales = $this->_cexHelpers->getUserCredentials();
        $peticion = array(
            'cod_postal' => $this->getRequest()->getPost('cod_postal'),
            'poblacion' => $this->getRequest()->getPost('poblacion')
        );
        $data = $this->_cexHelpers->getJsonEncode($peticion);

        $url = $this->_cexHelpers->getCustomerOptionsClave('MXPS_APIRESTOFI');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $credenciales['usuario'] . ":" . $credenciales['password']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ));

        $output = curl_exec($ch);

        curl_close($ch);

        echo $output;
    }

    public function ejecutarCron()
    {
        $this->_cexHelpers->comprobarCronAjax();
    }

    public function generarEtiquetasReimpresion($numCollect = false, $tipoEtiqueta = false, $posicion = false, $tipoReimpresion = false)
    {
        if (!$numCollect) {
            $numCollect = $_POST['numCollect'];
            $tipoEtiqueta = intval($_POST['tipoEtiqueta']);
            $posicion = intval($_POST['posicion']);
            $tipoReimpresion = intval($_POST['tipoReimpresion']);
        }

        $rest = $this->_cexRest->cexEnviarPeticionReimpresion($numCollect, $tipoEtiqueta, $posicion);
        $curl = $this->_cexRest->cexProcesarCurlReimpresion($rest);
        $retorno = $this->_cexRest->cexProcesarRespuestaReimpresion($curl, $tipoReimpresion, $numCollect,array());

        echo json_encode($retorno);
        exit;
    }
}
