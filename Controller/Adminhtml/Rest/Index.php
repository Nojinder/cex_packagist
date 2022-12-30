<?php

namespace CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Rest;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Sales\Model\Order\ShipmentFactory;
use Magento\Framework\DB\TransactionFactory;
use CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Helpers\Index as HelpersIndex;
use CorreosExpress\RegistroDeEnvios\Model\CexSavedshipRepository;
use CorreosExpress\RegistroDeEnvios\Api\CexHistoryRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexSavedship\CollectionFactory as SavedShipsCollectionFactory;
use CorreosExpress\RegistroDeEnvios\Api\CexSavedmodeshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnviobultosInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\CexEnviobultosRepositoryInterface;
use stdClass;


/**
 *
 */
class Index extends Action
{
    protected $_pageFactory;
    protected $_cexHelpers;
    protected $_resource;
    protected $_productMetadataInterface;
    protected $_shipmentFactory;
    protected $_transactionFactory;
    protected $cexSavedshipRepository;
    protected $filterBuilder;
    protected $cexHistoryRepository;
    protected $cexSavedmodeshipRepository;
    protected $cexSavedshipCollectionFactory;
    protected $cexEnviobultosFactory;
    protected $cexEnviobultosRepository;
    protected $searchCriteriaBuilder;

    /**
     * Index constructor.
     *
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param HelpersIndex $cexHelpers
     * @param ResourceConnection $resource
     * @param ProductMetadataInterface $productMetadataInterface
     * @param ShipmentFactory $shipmentFactory
     * @param TransactionFactory $transactionFactory
     * @param CexSavedshipRepository $cexSavedshipRepository
     * @param CexHistoryRepositoryInterface $cexHistoryRepository
     * @param CexSavedmodeshipRepositoryInterface $cexSavedmodeshipRepository
     * @param CexEnviobultosInterfaceFactory $cexEnviobultosFactory
     * @param CexEnviobultosRepositoryInterface $cexEnviobultosRepository
     * @param FilterBuilder $filterBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SavedShipsCollectionFactory $cexSavedshipCollectionFactory
     */

    public function __construct(
        Context                             $context,
        PageFactory                         $pageFactory,
        HelpersIndex                        $cexHelpers,
        ResourceConnection                  $resource,
        ProductMetadataInterface            $productMetadataInterface,
        ShipmentFactory                     $shipmentFactory,
        TransactionFactory                  $transactionFactory,
        CexSavedshipRepository              $cexSavedshipRepository,
        CexHistoryRepositoryInterface       $cexHistoryRepository,
        CexSavedmodeshipRepositoryInterface $cexSavedmodeshipRepository,
        CexEnviobultosInterfaceFactory      $cexEnviobultosFactory,
        CexEnviobultosRepositoryInterface   $cexEnviobultosRepository,
        FilterBuilder                       $filterBuilder,
        SearchCriteriaBuilder               $searchCriteriaBuilder,
        SavedShipsCollectionFactory         $cexSavedshipCollectionFactory
    )
    {
        parent::__construct($context);
        $this->_pageFactory = $pageFactory;
        $this->_cexHelpers = $cexHelpers;
        $this->_resource = $resource;
        $this->_productMetadataInterface = $productMetadataInterface;
        $this->_shipmentFactory = $shipmentFactory;
        $this->_transactionFactory = $transactionFactory;
        $this->cexSavedshipRepository = $cexSavedshipRepository;
        $this->cexHistoryRepository = $cexHistoryRepository;
        $this->cexSavedmodeshipRepository = $cexSavedmodeshipRepository;
        $this->cexSavedshipCollectionFactory = $cexSavedshipCollectionFactory;
        $this->cexEnviobultosFactory = $cexEnviobultosFactory;
        $this->cexEnviobultosRepository = $cexEnviobultosRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        return $resultPage;
    }

    public function cexValidarCredenciales()
    {
        $usuario = $_POST['user'];
        $pass = $_POST['pass'];
        $peticionValidacion = $this->enviarPeticionValidacionCex();
        $retorno = $this->procesarCurlValidacion($peticionValidacion, $usuario, $pass);
        $respuesta_validacion = $this->procesarPeticionValidacionCex($retorno);

        echo $this->_cexHelpers->getJsonEncode($respuesta_validacion);
    }

    private function enviarPeticionValidacionCex()
    {
        $url = $this->_cexHelpers->getCustomerOptionsClave('MXPS_WSURL');
        $data = array(
            "solicitante" => "",
            "numEnvio" => "",
            "ref" => "",
            "refCliente" => "",
            "fecha" => "",
            "codRte" => "",
            "nomRte" => "",
            "nifRte" => "",
            "dirRte" => "",
            "pobRte" => "",
            "codPosNacRte" => "",
            "paisISORte" => "",
            "codPosIntRte" => "",
            "contacRte" => "",
            "telefRte" => "",
            "emailRte" => "",
            "codDest" => "",
            "nomDest" => "",
            "nifDest" => "",
            "dirDest" => "",
            "pobDest" => "",
            "codPosNacDest" => "",
            "paisISODest" => "",
            "codPosIntDest" => "",
            "contacDest" => "",
            "telefDest" => "",
            "emailDest" => "",
            "contacOtrs" => "",
            "telefOtrs" => "",
            "emailOtrs" => "",
            "observac" => "",
            "numBultos" => "",
            "kilos" => "",
            "volumen" => "",
            "alto" => "",
            "largo" => "",
            "ancho" => "",
            "producto" => "",
            "portes" => "",
            "reembolso" => "",
            "entrSabado" => "",
            "seguro" => "",
            "numEnvioVuelta" => "",
            "listaBultos" => [],
            "codDirecDestino" => "",
            "password" => "",
            "listaInformacionAdicional" => []
        );

        $data["listaBultos"][] = $this->getListaBultosVacia();
        $data["listaInformacionAdicional"][] = $this->getListaAdicionalVacia();

        return [
            'peticion' => json_encode($data),
            'url' => $url,
        ];
    }

    private function procesarCurlValidacion($peticion, $usuario = null, $password = null)
    {
        $credenciales = array();
        if ($usuario == null && $password == null) {
            $credenciales = $this->_cexHelpers->getUserCredentials();
        } else {
            $credenciales['usuario'] = $usuario;
            $credenciales['password'] = $password;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $peticion['url']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $peticion['peticion']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $credenciales['usuario'] . ":" . $credenciales['password']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($peticion['peticion'])
        ));

        $output = curl_exec($ch);
        $codigo_error = curl_errno($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        switch ($codigo_error) {
            case 0:
                break;
            default:
                $data = ['codigo_retorno' => false];
                $output = $this->_cexHelpers->getJsonEncode($data);
                break;
        }
        curl_close($ch);
        return [
            'output' => $output,
            'status' => $status_code,
        ];
    }

    private function procesarPeticionValidacionCex($retorno)
    {

        switch ($retorno['status']) {
            case "401":
                $mensaje = array(
                    'title' => __('Error Validar Credenciales'),
                    'mensaje' => __('Las credenciales son incorrectas'),
                    'type' => 'error'
                );
                $validacion = false;
                break;
            case "200":
                $mensaje = array(
                    'title' => __('Credenciales correctas'),
                    'mensaje' => __('Guarde sus credenciales en un lugar seguro'),
                    'type' => 'success'
                );
                $validacion = true;
                break;
            default:
                $mensaje = array(
                    'title' => __('Error Validar Credenciales'),
                    'mensaje' => __('Servicio temporalmente fuera de servicio, inténtelo más tarde'),
                    'type' => 'error'
                );
                $validacion = false;
                break;
        }
        return array(
            'mensaje' => $mensaje,
            'validacion' => $validacion
        );
    }

    public function enviarPeticionEnvioRestCex($datos)
    {
        $url = $this->_cexHelpers->getCustomerOptionsClave('MXPS_WSURL');
        $fecha = $datos['datepicker'];
        $fechaformat = explode('-', $fecha);
        $longitud = 5;
        $cprem = $datos['postcode_sender'];
        $cpdest = $datos['postcode_receiver'];
        $postcode_sender = $this->_cexHelpers->cexRellenarCeros($cprem, $longitud);
        $codigo_cliente = substr($datos["codigo_cliente"], 0, 5);
        $codigo_solicitante = $this->obtenerCodigoSolicitante() . $codigo_cliente;

        $data = array(
            "solicitante" => $codigo_solicitante,
            "canalEntrada" => "",
            "numEnvio" => "",
            "ref" => $datos['ref_ship'],
            "refCliente" => $datos['ref_ship'],
            "fecha" => $fechaformat[2] . '-' . $fechaformat[1] . '-' . $fechaformat[0],
            "codRte" => $datos['codigo_cliente'],
            "nomRte" => $datos['name_sender'],
            "nifRte" => "",
            "dirRte" => $datos['address_sender'],
            "pobRte" => $datos['city_sender'],
            "codPosNacRte" => $cprem,
            "paisISORte" => $datos['iso_code_remitente'],
            "codPosIntRte" => "",
            "contacRte" => $datos['contact_sender'],
            "telefRte" => $datos['phone_sender'],
            "emailRte" => $datos['email_sender'],
            "codDest" => "",
            "nomDest" => $datos['name_receiver'],
            "nifDest" => "",
            "dirDest" => $datos['address_receiver'],
            "pobDest" => $datos['city_receiver'],
            "contacDest" => $datos['contact_receiver'],
            "telefDest" => $datos['phone_receiver1'],
            "emailDest" => $datos['email_receiver'],
            "contacOtrs" => "",
            "telefOtrs" => $datos['phone_receiver2'],
            "emailOtrs" => "",
            "observac" => "",
            "numBultos" => $datos['bultos'],
            "kilos" => floatval($this->_cexHelpers->calcularPesoEnKilos($datos['kilos'])),
            "volumen" => "",
            "alto" => "",
            "largo" => "",
            "ancho" => "",
            "producto" => $datos['selCarrier'],
            "portes" => "P",
            "seguro" => "",
            "numEnvioVuelta" => "",
            "listaBultos" => [],
            "codDirecDestino" => "",
            "password" => "",
        );

        if ($datos['selCarrier'] == 44) {
            $data['observac'] = "";
        } else {
            $data['observac'] = $datos['note_deliver'];
        }

        if ($datos['iso_code_remitente'] == 'ES') {
            $data['codPosNacRte'] = $postcode_sender;
            $data['paisISORte'] = $datos['iso_code_remitente'];
            $data['codPosIntRte'] = "";
        } elseif ($datos['iso_code_remitente'] == 'PT') {
            $data['codPosNacRte'] = "";
            $data['paisISORte'] = $datos['iso_code_remitente'];
            $data['codPosIntRte'] = $cprem;
        } else {
            $data['codPosNacRte'] = "";
            $data['paisISORte'] = $datos['iso_code_remitente'];
            $data['codPosIntRte'] = $postcode_sender;
        }

        if ($datos['iso_code'] == 'ES') {
            $data['codPosNacDest'] = $cpdest;
            $data['paisISODest'] = $datos['iso_code'];
            $data['codPosIntDest'] = "";
        } elseif ($datos['iso_code'] == 'PT') {
            $data['codPosNacDest'] = "";
            $data['paisISODest'] = $datos['iso_code'];
            $data['codPosIntDest'] = $cpdest;
        } else {
            $data['codPosNacDest'] = "";
            $data['paisISODest'] = $datos['iso_code'];
            $data['codPosIntDest'] = $cpdest;
        }

        if (!empty($datos['payback_val'])) {
            $data['reembolso'] = $datos['payback_val'];
        }
        if ($datos['deliver_sat'] == 'true') {
            $data['entrSabado'] = 'S';
        }
        if ($datos['entrega_oficina'] == 'true') {
            $data['codDirecDestino'] = $datos['codigo_oficina'];
        }

        for ($i = 1; $i <= $datos['bultos']; $i++) {
            $interior = new stdClass();
            $interior->alto = "";
            $interior->ancho = "";
            $interior->codBultoCli = $i;
            $interior->codUnico = "";
            $interior->descripcion = "";
            $interior->kilos = "";
            $interior->largo = "";
            $interior->observaciones = "";
            $interior->orden = $i;
            $interior->referencia = "";
            $interior->volumen = "";
            $data["listaBultos"][] = $interior;
        }

        $data["listaInformacionAdicional"][] = $this->obtenerListaAdicional($datos);

        return [
            'peticion' => $this->_cexHelpers->getJsonEncode($data),
            'url' => $url
        ];
    }

    public function procesarCurl($peticion, $usuario = null, $password = null)
    {
        $credenciales = array();
        if ($usuario == null && $password == null) {
            $credenciales = $this->_cexHelpers->getUserCredentials();
        } else {
            $credenciales['usuario'] = $usuario;
            $credenciales['password'] = $password;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $peticion['url']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $peticion['peticion']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $credenciales['usuario'] . ":" . $credenciales['password']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($peticion['peticion'])
        ));

        $output         = curl_exec($ch);
        $codigo_error   = curl_errno($ch);
        $error          = curl_error($ch);
        $status_code    = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'body' => $output,
            'status_code' => $status_code,
            'status_msg' => $this->_cexHelpers->getHttpStatusMessage($status_code)
        ];
    }

    public function procesarPeticionEnvioRestCex($rest, $retorno, $id_orden, $type, $numcollect)
    {
        $retornoObj = json_decode($retorno['body'], true);
        $restObj = json_decode($rest, true);
        $erroresHttp = $this->cex_errores_http($retorno);

        if ($erroresHttp['flag'] == true) {
            return $this->saveHistoryAndReturn($id_orden, $numcollect, $type, '', '0', $erroresHttp['mensajeRetorno'], '', $rest, $retorno['body'], '');
        } else {
            $mensaje_retorno = $retornoObj['mensajeRetorno'];
            $codigo_retorno = $retornoObj['codigoRetorno'];
            $datosResultado = $retornoObj['datosResultado'];

            if (strcmp("0", $codigo_retorno) != 0) {
                $ret = $this->saveHistoryAndReturn($id_orden, $numcollect, $type, $datosResultado, '0', $mensaje_retorno, $codigo_retorno, $rest, $retorno['body'], '');
            } else {
                $listaBultos = $retornoObj['listaBultos'];
                $etiqueta = $retornoObj['etiqueta'][0]['etiqueta1'];
                $numRecogida = $retornoObj['numRecogida'];

                $this->saveHistoryAndReturn($id_orden, $numcollect, $type, $datosResultado, '1', $mensaje_retorno, $codigo_retorno, $rest, $retorno['body'], '');
                foreach ($listaBultos as $bulto) {
                    $cexEnviobultosNew = $this->cexEnviobultosFactory->create();
                    $cexEnviobultosNew->setIdOrder($id_orden);
                    $cexEnviobultosNew->setNumCollect($numcollect);
                    $cexEnviobultosNew->setNumShip($datosResultado);
                    $cexEnviobultosNew->setCodUnicoBulto($bulto['codUnico']);
                    $cexEnviobultosNew->setIdBulto($bulto['orden']);
                    $cexEnviobultosNew->setFecha(date("Y-m-d H:i:s"));
                    $this->cexEnviobultosRepository->save($cexEnviobultosNew);
                }
                if (strcmp($restObj['listaInformacionAdicional'][0]['creaRecogida'], 'S') == 0) {
                    $this->guardarRecogidaRestHistorico($rest, $retorno['body'], $id_orden, $numcollect);
                    $ret = [
                        'id_order' => $id_orden,
                        'numCollect' => $numcollect,
                        'mensajeRetorno' => $mensaje_retorno,
                        'numShip' => $datosResultado,
                        'resultado' => '1',
                        'etiqueta' => $etiqueta,
                        'numRecogida' => $numRecogida,
                        'literalRecogida' => __('La petición de recogida ') . $numRecogida . __('se ha cursado con exito: '),
                        'literalEnvio' => __('La petición de envio ') . $datosResultado . __('se ha cursado con exito: ')
                    ];
                } else {
                    $ret = [
                        'id_order' => $id_orden,
                        'numCollect' => $numcollect,
                        'mensajeRetorno' => $mensaje_retorno,
                        'numShip' => $datosResultado,
                        'resultado' => '1',
                        'etiqueta' => $etiqueta,
                        'numRecogida' => 'Automatica',
                        'literalRecogida' => __('La recogida será Automática '),
                        'literalEnvio' => __('La petición de envio ') . $datosResultado . __('se ha cursado con exito: ')
                    ];
                }
            }
            $this->_cexHelpers->getCustomerOptionsClave('MXPS_TRACKING');

            if (strcmp('true', "checkTracking") == 0) {
                $this->cexSetWsShippingNumber($id_orden, $datosResultado);
            }
            return $ret;
        }
    }

    public function gestionarBorradoPedido($num_ship, $num_collect)
    {
        if (strcmp("", $num_ship) == 0 || $num_ship == null) {
            $this->_cexHelpers->deleteSavedShip($num_collect);
            return [
                'mensaje' => __('El envío ha sido borrado correctamente')
            ];
        }

        $ordenes = $this->_cexHelpers->obtenerOrdenByNumCollect($num_collect);
        foreach ($ordenes as $orden) {
            if (strcmp('Recogida', $orden->getType()) == 0 && strcmp('Automatica', $orden->getNumShip()) != 0) {
                $peticion = $this->enviarPeticionBorradoRecogida($orden->getNumShip(), $orden->getCodigoCliente());
                $curl = $this->procesarCurlBorrado($peticion);
                $this->procesarPeticionBorrado($curl, $orden->getNumShip(), $peticion, $num_collect);
            }
        }
        $this->_cexHelpers->deleteSavedShip($num_collect);
        return [
            'mensaje' => __('El envío ') . $num_ship . __('ha sido borrado correctamente')
        ];
    }

    public function enviarPeticionBorradoRecogida($numship, $codigo_cliente)
    {
        $url = $this->_cexHelpers->getCustomerOptionsClave('MXPS_WSURLANULREC');
        $idioma = $this->_cexHelpers->obtenerIdiomaUsuario();
        $data = array(
            "solicitante" => "M" . $codigo_cliente,
            "password" => "",
            "keyRecogida" => $numship,
            "strTextoAnulacion" => "Anulacion E-Commerce",
            "strUsuario" => "",
            "strReferencia" => "",
            "strCodCliente" => "",
            "strFRecogida" => "",
            "idioma" => $idioma
        );
        return [
            'peticion' => $this->_cexHelpers->getJsonEncode($data),
            'url' => $url,
        ];
    }

    private function procesarCurlBorrado($peticion)
    {

        $credenciales = $this->_cexHelpers->getUserCredentials();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $peticion['url']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $peticion['peticion']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $credenciales['usuario'] . ":" . $credenciales['password']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($peticion['peticion'])
        ));

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }

    public function procesarPeticionBorrado($curl, $numship, $peticion, $numcollect)
    {
        $fecha = date("Y-m-d H:i:s");
        $curlDecode = json_decode($curl, true);
        $codigoError = $curlDecode['codError'];
        $mensajeRetorno = $curlDecode['mensError'];
        if (empty($mensajeRetorno) || $mensajeRetorno == NULL) {
            $mensajeRetorno = 'Recogida borrada correctamente';
        }
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('num_ship', $numship, 'eq')
            ->create();
        $items = $this->cexHistoryRepository
            ->getList($searchCriteria)
            ->getItems();
        $item = reset($items);
        $id_order = $item->getIdOrder();

        $this->_cexHelpers->cexGuardarHistorico($id_order, $numcollect, 'Recogida Borrada', $numship, $fecha, 0, $mensajeRetorno, intval($codigoError), $peticion['peticion'], $curl, NULL, NULL, NULL, NULL, NULL);
    }

    public function cexEnviarPeticionReimpresion($numCollect, $tipoEtiqueta, $posicion)
    {
        $peticiones = [];
        $hideSender = $this->valorHideSender();
        $logo = $this->codificarLogo();
        $url = $this->_cexHelpers->getCustomerOptionsClave('MXPS_REPRINTWS');
        $in = '(';
        foreach ($numCollect as $ref) {
            $in .= '"' . $ref . '",';
        }
        $in = substr($in, 0, -1);
        $in .= ')';
        $savedShipCollection = $this->cexSavedshipCollectionFactory->create();
        $savedShipCollection->addFieldToSelect('codigo_cliente');
        $select = $savedShipCollection->getSelect();
        $select->where('main_table.num_collect IN  ' . $in);
        $select->where('main_table.type =  "Envio"');
        $select->where('main_table.deleted_at IS NULL');
        $select->group('main_table.codigo_cliente');

        $codigos_cliente = $savedShipCollection->getData();

        foreach ($codigos_cliente as $codigo_cliente) {
            $filters[] = $this->filterBuilder
                ->setField('num_collect')
                ->setValue($numCollect)
                ->setConditionType('in')
                ->create();

            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilters($filters)
                ->addFilter('type', 'Envio')
                ->addFilter('deleted_at', '', 'null')
                ->addFilter('codigo_cliente', $codigo_cliente['codigo_cliente'], 'eq')
                ->create();

            $rows = $this->cexSavedshipRepository
                ->getList($searchCriteria)
                ->getItems();
            $lista = [];

            $etiqueta = $this->obtenerTipoEtiqueta($tipoEtiqueta);

            foreach ($rows as $row) {
                $packingList = "";
                if(strcmp($etiqueta, "5") == 0){
                    $packingList = $this->_cexHelpers->retornarNombresProductos($row->getIdOrder());
                }

                $datoEnvio = new stdClass();
                $iso_code = $row->getIsoCode();
                $datoEnvio->nEnvio = $row->getNumShip();
                $datoEnvio->packingList = $packingList;
                $aux['datoEnvio'] = $datoEnvio;
                array_push($lista, $aux);
            }
            $data = array(
                "listaEnvios" => $lista,
                "hideSender" => $hideSender['hideSender'],
                "idioma" => $iso_code,
                "keyCli" => $codigo_cliente['codigo_cliente'],
                "logoCliente" => $logo,
                "posicionEtiqueta" => $this->obtenerPosicionEtiqueta($posicion),
                "textoRemiAlternativo" => $hideSender['textoRemiAlternativo'],
                "tipo" => $etiqueta
            );
            array_push($peticiones, json_encode($data));

        }
        return [
            'peticiones' => $peticiones,
            'url' => $url
        ];
    }

    public function cexProcesarCurlReimpresion($rest)
    {
        $credenciales = $this->_cexHelpers->getUserCredentials();
        $url = $rest['url'];
        $retorno = [];

        foreach ($rest['peticiones'] as $request) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $credenciales['usuario'] . ":" . $credenciales['password']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($request)
            ));

            $output = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            $this->guardarRestHistorico($request, $output, $status_code, "Reimpresion");
            $ret = [
                'body' => $output,
                'status_code' => $status_code,
                'status_msg' => $this->_cexHelpers->getHttpStatusMessage($status_code)
            ];
            array_push($retorno, $ret);
        }
        return $retorno;

    }

    public function cexProcesarRespuestaReimpresion($curl, $tipoReimpresion, $numCollects,$erroresGrabacion)
    {
        $retorno = [];
        $etiquetasErrores = $this->gestionarErrores($curl);
        $allErrors          = [];
        $allErrors          = array_merge($erroresGrabacion,$etiquetasErrores['errores']);
        $hayErrores         = count($allErrors);
        if($hayErrores != 0){
            switch ($tipoReimpresion) {
                case 0:
                    $retorno['errores'] = $this->_cexHelpers->pintarErroresMasiva($etiquetasErrores['errores'], 'erroresReimpresion', $tipoReimpresion);
                    break;
                case 1:
                    $retorno['errores'] = $this->_cexHelpers->pintarErroresMasiva($allErrors, 'erroresMasiva', $tipoReimpresion);
                    break;
                case 2:
                    $retorno['errores'] = $this->_cexHelpers->pintarErroresMasiva($etiquetasErrores['errores'], '', $tipoReimpresion);
                    break;
            }
        } else {
            $retorno['errores'] = false;
        }
        $retorno['etiquetas'] = $etiquetasErrores['etiquetas'];
        return $retorno;
    }

    public function procesarCurlCron($peticion, $usuario = null, $password = null)
    {
        $credenciales = array();
        if ($usuario == null && $password == null) {
            $credenciales = $this->_cexHelpers->getUserCredentials();
        } else {
            $credenciales['usuario'] = $usuario;
            $credenciales['password'] = $password;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $peticion['url']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $peticion['peticion']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $credenciales['usuario'] . ":" . $credenciales['password']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($peticion['peticion'])
        ));

        $output = curl_exec($ch);
        $codigo_error = curl_errno($ch);
        $error = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return [
            'output' => $output,
            'status' => $status,
            'codigo_error' => $codigo_error,
            'error' => $error,
        ];
    }

    private function getListaBultosVacia()
    {
        $interior = new stdClass();
        $interior->alto = "";
        $interior->ancho = "";
        $interior->codBultoCli = "";
        $interior->codUnico = "";
        $interior->descripcion = "";
        $interior->kilos = "";
        $interior->largo = "";
        $interior->observaciones = "";
        $interior->orden = "";
        $interior->referencia = "";
        $interior->volumen = "";
        return $interior;
    }

    private function getListaAdicionalVacia()
    {
        $lista = new stdClass();
        $lista->tipoEtiqueta = "";
        $lista->etiquetaPDF = "";
        $lista->posicionEtiqueta = "";
        $lista->hideSender = "";
        $lista->codigoAT = "";
        $lista->logoCliente = "";
        $lista->codificacionUnicaB64 = "";
        $lista->textoRemiAlternativo = "";
        $lista->idioma = "";
        $lista->creaRecogida = "";
        $lista->fechaRecogida = "";
        $lista->horaDesdeRecogida = "";
        $lista->horaHastaRecogida = "";
        $lista->referenciaRecogida = "";
        return $lista;
    }

    private function obtenerPosicionEtiqueta($posicionEtiqueta)
    {
        switch ($posicionEtiqueta) {
            case '2':
                return '1';
            case '3':
                return '2';
            default:
                return '0';
        }
    }

    private function obtenerTipoEtiqueta($tipoEtiqueta)
    {
        switch ($tipoEtiqueta) {
            case '1':
                return "3";
            case '2':
                return "4";
            default:
                return "5";
        }
    }


    private function obtenerListaAdicional($datos)
    {
        $fecha = $datos['datepicker'];
        $fechaformat = explode('-', $fecha);
        $lista = new stdClass();
        $valorHideSender = $this->valorHideSender();
        $packingList = "";

        switch ($datos['tipoEtiqueta']) {
            case '1':
                $lista->tipoEtiqueta = "3";
                $lista->posicionEtiqueta = $this->obtenerPosicionEtiqueta($datos['posicionEtiqueta']);
                break;
            case '2':
                $lista->tipoEtiqueta = "4";
                $lista->posicionEtiqueta = $this->obtenerPosicionEtiqueta($datos['posicionEtiqueta']);
                break;
            default:
                $lista->tipoEtiqueta = "5";
                $packingList = $this->_cexHelpers->retornarNombresProductos($datos['id']);
                break;
        }

        $lista->hideSender = $valorHideSender['hideSender'];
        $lista->codificacionUnicaB64 = "1";
        $lista->logoCliente = $this->codificarLogo();
        $lista->idioma = $this->_cexHelpers->obtenerIdiomaUsuario();
        $lista->textoRemiAlternativo = $valorHideSender['textoRemiAlternativo'];
        $lista->etiquetaPDF = "";
        $lista->packingList = $packingList;

        if (!empty($datos['at_portugal'])) {
            $lista->codigoAT = $datos['at_portugal'];
        }

        if (strcmp($datos['grabar_recogida'], 'false') == 0) {
            $lista->creaRecogida = 'N';
        } else {
            $lista->creaRecogida = 'S';
            $lista->fechaRecogida = $fechaformat[2] . $fechaformat[1] . $fechaformat[0];
            $lista->horaDesdeRecogida = $datos['fromHH_sender'] . ':' . $datos['fromMM_sender'];
            $lista->horaHastaRecogida = $datos['toHH_sender'] . ':' . $datos['toMM_sender'];
            $lista->referenciaRecogida = "";
        }
        return $lista;
    }

    private function obtenerCodigoSolicitante()
    {
        $versionCEX = $this->_cexHelpers->retornarVersionModulo();
        $versionCEX = str_replace('.', '', $versionCEX);
        $versionCms = $this->_productMetadataInterface->getVersion();
        $versionCms = str_replace('.', '', $versionCms);
        $versionCms = substr($versionCms, 0, 3);
        return 'M' . $versionCms . "_" . $versionCEX . "_";
    }

    private function codificarLogo()
    {
        $checkLogo = $this->_cexHelpers->getCustomerOptionsClave('MXPS_CHECKUPLOADFILE');
        $rutaLogo = $this->_cexHelpers->getCustomerOptionsClave('MXPS_UPLOADFILE');
        $dirnameLogo = "/view/adminhtml/web/images/LogoImagen." . substr($rutaLogo, strrpos($rutaLogo, '.') + 1);

        $path = dirname(__FILE__, 4) . $dirnameLogo;
        if (strcmp($checkLogo, 'true') == 0) {
            $datos = file_get_contents($path, true);
            $retorno = base64_encode($datos);

        } else {
            $retorno = "";
        }
        return $retorno;
    }

    private function valorHideSender()
    {
        $hideSender = $this->_cexHelpers->getCustomerOptionsClave('MXPS_LABELSENDER');
        $textoAdicional = $this->_cexHelpers->getCustomerOptionsClave('MXPS_LABELSENDER_TEXT');
        if ($hideSender == 'true') {
            $retorno = [
                'hideSender' => '1',
                'textoRemiAlternativo' => $textoAdicional
            ];
        } else {
            $retorno = [
                'hideSender' => '0',
                'textoRemiAlternativo' => ''
            ];
        }
        return $retorno;
    }

    private function cex_errores_http($retorno)
    {
        $flag           = false;
        $mensajeRetorno = "";
        if (empty($retorno['body'])) {
            $flag = true;
            $mensajeRetorno = __('Petición sin respuesta');
        } else {
            switch($retorno['status_code']){
                case 404:
                case 500:
                case 401:
                case 400:
                case 503:
                case 408:
                    $flag = true;
                    $mensajeRetorno = __('Error Http: ').$retorno['status_code'].__('. Mensaje-> ').$retorno['status_msg'];
                    break;
            }
        }
    
        return array(
            'flag' => $flag,
            'mensajeRetorno' => $mensajeRetorno
        );
    }

    private function saveHistoryAndReturn($id_order, $num_collect, $type, $num_ship, $resultado, $mensaje, $cod_ret, $envio_ws, $respuesta_ws, $num_recogida)
    {
        $fecha = date("Y-m-d H:i:s");
        $url = $this->getUrl('sales/order/view', ['order_id' => $id_order]);
        $respuesta_ws_objeto = json_decode($respuesta_ws);
        $producto = '63';
        $envio_wsJSON = json_decode($envio_ws, true);
        $listaInfoAdicionalArray = $envio_wsJSON['listaInformacionAdicional'];
        $listaInfoAdicionalArray[0]['logoCliente'] = "";
        $envio_wsJSON['listaInformacionAdicional'] = $listaInfoAdicionalArray;
        $envio_wsString = json_encode($envio_wsJSON);
        $modeShipName = $this->modeShipNameByIdBc($producto);

        if (isset($respuesta_ws_objeto->producto)) {
            $producto = $respuesta_ws_objeto->producto;
        }

        $this->_cexHelpers->cexGuardarHistorico($id_order, $num_collect, $type, $num_ship, $fecha, $resultado, $mensaje, intval($cod_ret), $envio_wsString, $respuesta_ws, $producto, $modeShipName, NULL, NULL, NULL);

        return [
            'id_order' => $id_order,
            'numCollect' => $num_collect,
            'mensajeRetorno' => $mensaje,
            'numShip' => $num_ship,
            'resultado' => $resultado,
            'numRecogida' => $num_recogida,
            'url' => $url
        ];
    }

    private function modeShipNameByIdBc($id_bc)
    {
        if (!is_null($id_bc)) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter('id_bc', $id_bc)
                ->create();

            $savedModeshipList = $this->cexSavedmodeshipRepository
                ->getList($searchCriteria)
                ->getItems();
            $savedModeshipList = reset($savedModeshipList);
            return $savedModeshipList->getName();
        } else {
            return null;
        }
    }

    private function guardarRecogidaRestHistorico($rest, $retorno, $id_orden, $numcollect)
    {
        $fecha = date("Y-m-d H:i:s");

        $retornoObj = json_decode($retorno, true);
        $envio_wsJSON = json_decode($rest, true);
        $listaInfoAdicionalArray = $envio_wsJSON['listaInformacionAdicional'];
        $listaInfoAdicionalArray[0]['logoCliente'] = "";
        $envio_wsJSON['listaInformacionAdicional'] = $listaInfoAdicionalArray;
        $envio_wsString = json_encode($envio_wsJSON);

        if (empty($retorno)) {
            $this->_cexHelpers->cexGuardarHistorico((int)$id_orden, $numcollect, 'Recogida', '', $fecha, '0', 'RECError [WS] conection', '', addslashes($envio_wsString), $retorno, NULL, NULL, NULL, NULL, NULL);
        } else {
            $mensajeRetorno = $retornoObj['mensajeRetorno'];
            $codigoRetorno = $retornoObj['codigoRetorno'];
            $datosResultado = $retornoObj['numRecogida'];
            $fechaRecogida = $retornoObj['fechaRecogida'];
            $fechaDia = substr($fechaRecogida, 0, -6);
            $fechaMes = substr($fechaRecogida, 2, -4);
            $fechaAnno = substr($fechaRecogida, 4, 4);
            $fechaFormato = $fechaAnno . "-" . $fechaMes . "-" . $fechaDia;
            $horaRecogidaDesde = $retornoObj['horaRecogidaDesde'];
            $horaRecogidaHasta = $retornoObj['horaRecogidaHasta'];
            unset($retornoObj['etiqueta']);
            $retornoAux = json_encode($retornoObj);
            $this->_cexHelpers->cexGuardarHistorico((int)$id_orden, $numcollect, 'Recogida', $datosResultado, $fecha, '1', $mensajeRetorno, $codigoRetorno, $envio_wsString, $retornoAux, NULL, NULL, $fechaFormato, $horaRecogidaDesde, $horaRecogidaHasta);
        }
    }

    private function guardarRestHistorico($rest, $curl, $status_code, $type)
    {
        $fecha = date("Y-m-d H:i:s");
        if (empty($curl) || $status_code != 200) {
            $this->_cexHelpers->cexGuardarHistorico(0, '', $type, '', $fecha, 0, 'RECError [WS] conection - HTTP_ERR = ' . $status_code, 0, $rest, $curl, NULL, NULL, NULL, NULL, NULL);

        } else {
            $restObj = json_decode($rest, true);
            $curlObj = json_decode($curl, true);
            $curlObj['listaEtiquetas']      = '';
            $restObj['logoCliente']         = '';
            $mensajeRetorno                 = 'Error de respuesta';
            $codigoRetorno                  = 0;
            if(strcmp('Reimpresion',$type)  == 0){
                $mensajeRetorno             = $curlObj['desErr'];
                $codigoRetorno              = $curlObj['codErr'];  
            }
            $this->_cexHelpers->cexGuardarHistorico(0, '', $type, '', $fecha, 1, $mensajeRetorno, intval($codigoRetorno), json_encode($restObj), json_encode($curlObj), NULL, NULL, NULL, NULL, NULL);
        }
    }

    private function gestionarErrores($curl)
    {
        $retorno    = [];
        $errores    = [];
        $etiquetas  = [];
        foreach ($curl as $respuesta) {
            if (!empty($respuesta['status_code']) || !empty($respuesta['body'])) {
                $http_status = $respuesta['status_code'];
                switch ($http_status) {
                    case 200:
                        $respuestaObj = json_decode($respuesta['body']);
                        $aux = $this->obtenerErroresRespuesta($respuestaObj);

                        if(!is_null($aux['etiquetas'])){
                            foreach($aux['etiquetas'] as $etiqueta){
                                array_push($etiquetas,$etiqueta);

                            } 
                        } 

                        if (count($aux['errores']) != 0) {
                            foreach ($aux['errores'] as $error) {
                                array_push($errores, $error);
                            }
                        }

                        break;
                    case 400:
                    case 500:
                    case 404:
                    case 408:
                    case 401:
                    default:
                        $error = $this->_cexHelpers->crearError(0, 0, 'Error Http: ' . $http_status . '. Mensaje-> ' . $respuesta['status_msg'], '-2');
                        array_push($errores, $error);
                        break;
                }
            }
        }
        return [
            'errores' => $errores,
            'etiquetas' => $etiquetas
        ];
    }

    function obtenerErroresRespuesta($respuestaObj)
    {
        $etiquetas = [];
        $errores = [];
        if (isset($respuestaObj->codErr)) {
            switch ($respuestaObj->codErr) {
                case 0:
                    array_push($etiquetas, $respuestaObj->listaEtiquetas);
                    break;
                case 1:
                    array_push($etiquetas, $respuestaObj->listaEtiquetas);
                    foreach ($respuestaObj->listaErrores as $item) {
                        $num_ship = $item->nEnvio;
                        $searchCriteria = $this->searchCriteriaBuilder
                            ->addFilter('type', 'Envio')
                            ->addFilter('num_ship', $num_ship, 'eq')
                            ->create();

                        $rows = $this->cexSavedshipRepository
                            ->getList($searchCriteria)
                            ->getItems();
                        $row = reset($rows);
                        $error = $this->_cexHelpers->crearError($row->getIdOrder(), $row->getNumCollect(), $item->desErr, $item->codError);
                        array_push($errores, $error);
                    }
                    break;
                default:
                    $error = $this->_cexHelpers->crearError(0, 0, $respuestaObj->desErr, $respuestaObj->codErr);
                    array_push($errores, $error);
                    break;
            }
        } else {
            die('no hay corErr');
        }

        return [
            'errores' => $errores,
            'etiquetas' => $etiquetas
        ];

    }

    function cexEnviarPeticionResumen($numCollect){
        $peticiones             = [];
        $fecha                  = date("Y-m-d H:i:s"); 
        $logo                   = $this->codificarLogo();
        $url                    = $this->_cexHelpers->getCustomerOptionsClave('MXPS_REPORTWS');
        $savedShipCollection    = $this->cexSavedshipCollectionFactory->create();
            $savedShipCollection->addFieldToSelect('codigo_cliente');
            $savedShipCollection->addFieldToFilter('num_collect',array('in'=> $numCollect ));
            $savedShipCollection->addFieldToFilter('type',array('ep'=> 'Envio' ));
            $savedShipCollection->addFieldToFilter('deleted_at',array( 'null' => 1));
        $select                 = $savedShipCollection->getSelect()->group('codigo_cliente');
        $codigos_cliente        = $savedShipCollection->getData();

        foreach($codigos_cliente as $codigo_cliente){
            $lista  = [];
            $jsonEnvio        = new \stdClass();
            $codigo_cliente   = $codigo_cliente['codigo_cliente'];
            $nEnvios          = [];
            $rows   = $this->cexSavedshipCollectionFactory->create()
                ->addFieldToSelect('*')
                ->addFieldToFilter('num_collect',array('in'=> $numCollect ))
                ->addFieldToFilter('type',array('ep'=> 'Envio' ))
                ->addFieldToFilter('codigo_cliente',array('codigo_cliente'=> $codigo_cliente))
                ->addFieldToFilter('deleted_at',array( 'null' => 1))
                ->getData();

            foreach($rows as $row){                
                array_push($nEnvios,$row['num_ship']);
            }

            $jsonEnvio->nEnvios = $nEnvios;
            $jsonEnvio->fecha = $fecha;
            $jsonEnvio->keyclifac = $codigo_cliente;
            $jsonEnvio->logoCliente = $logo;

            array_push($peticiones,json_encode($jsonEnvio)); 
        }

        $ret = [
            'peticiones' => $peticiones,
            'url'        => $url
        ];
        return $ret;
    }

    function cexProcesarCurlResumen($rest){
        $credenciales = $this->_cexHelpers->getUserCredentials();
        $url= $rest['url'];
        $retorno=[];

        foreach($rest['peticiones'] as $request){
            $header = array('Content-Type: application/json',
                'Content-Length: '.strlen($request)
            );
            $ch         = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $credenciales['usuario'].":".$credenciales['password']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: '.strlen($request)
            ));

            $output         = curl_exec($ch);
            $error          = curl_error($ch);
            $status_code    = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
            $info           = curl_getinfo($ch);
            $codigo_error   = curl_errno($ch);
            curl_close($ch);
            $this->guardarRestHistorico($request, $output, $status_code, "Resumen");

            $ret = [
                'body'          => $output,
                'status_code'   => $status_code,
                'status_msg'    => $this->_cexHelpers->getHttpStatusMessage($status_code)
            ];
            array_push($retorno,$ret);
        }
        return $retorno;
    }

    function cexProcesarRespuestaResumen($curl){
        $retorno            = [];
        $retorno['errors']  = false;
        $errors             = [];
        $reports            = [];
        foreach($curl as $item){
            $http_status = $item['status_code'];  
                switch($http_status){
                    case 200:                    
                        $resumen = substr($item['body'],11);
                        $resumen = substr($resumen,0,-2);
                        array_push($reports,$resumen);
                    break;
                    case 400:
                    case 500:
                    case 404:
                    case 401:
                    default:
                        $error = $this->_cexHelpers->crearError(0, 0, __('Error Http: ').$http_status. __(' Mensaje-> ').$item['status_msg'], '-2');
                        array_push($errors,$error);    
                    break;
                }            
        } 
        if(count($errors) != 0){
            $retorno['errors'] = $this->_cexHelpers->pintarErroresMasiva($errors,'erroresResumen',4);      
        }
           
        $retorno['reports'] = $reports;
        return $retorno;
    }

    private function cexSetWsShippingNumber($idOrder, $numEnvio)
    {
        $order = $this->_cexHelpers->retornarOrdenById($idOrder);

        if (!empty($numEnvio)) {
            $data = array(array(
                'carrier_code' => 'CEX',
                'title' => 'correosexpress',
                'number' => $numEnvio,
            ));

            $shipment = $this->prepareShipment($order, $data);

            if ($shipment) {
                $transactionSave = $this->_transactionFactory->create();
                $transactionSave->addObject($shipment);
                $transactionSave->addObject($shipment->getOrder());
                $transactionSave->save();
            } else {
                $table = $this->_resource->getTableName('sales_shipment_track');

                $query = "UPDATE " . $table . " SET track_number='" . $numEnvio . "' ,updated_at=now() WHERE order_id = " . $idOrder;

                $readConnection = $this->_resource->getConnection('core_read');
                $readConnection->exec($query);
            }
        }
    }

    private function prepareShipment($order, $data)
    {
        $shipment = $this->_shipmentFactory->create(
            $order,
            $this->prepareShipmentItems($order),
            $data
        );
        return $shipment->getTotalQty() ? $shipment->register() : false;
    }

    private function prepareShipmentItems($order)
    {
        $items = [];
        foreach ($order->getAllItems() as $item) {
            $items[$item->getItemId()] = $item->getQtyOrdered();
        }
        return $items;
    }
}
