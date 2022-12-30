<?php

namespace CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Helpers;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Module\ResourceInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Sales\Api\Data\OrderInterfaceFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Model\ResourceModel\Order\Status\Collection as OrderStatusCollection;
use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory as OrderStatusCollectionFactory;
use Magento\Sales\Api\Data\OrderStatusHistoryInterface;
use Magento\Sales\Api\OrderStatusHistoryRepositoryInterface as OrderStatusHistoryRepository;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;

//CEX
//interface factory
use CorreosExpress\RegistroDeEnvios\Api\Data\CexSavedshipInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexEnvioCronInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexHistoryInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexRespuestaCronInterfaceFactory;
use CorreosExpress\RegistroDeEnvios\Api\Data\CexMigrationInterfaceFactory;

//Repository Interfaces
use CorreosExpress\RegistroDeEnvios\Api\CexCustomeroptionRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexEnviobultosRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexEnvioCronRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexMigrationRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexOfficedeliverycorreoRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexRespuestaCronRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexSavedshipRepositoryInterface;
use CorreosExpress\RegistroDeEnvios\Api\CexHistoryRepositoryInterface;


class Index extends Action
{
    protected $resultJsonFactory;
    protected $authSession;
    protected $setup;
    protected $state;
    protected $_pageFactory;
    protected $json;
    protected $filterBuilder;
    protected $scopeConfig;
    protected $resolverStore;
    protected $storeManagerInterface;
    protected $dateTime;
    protected $_resource;
    protected $_resourceInterface;
    protected $sortOrderBuilder;
    protected $searchCriteriaBuilder;
    protected $orderInterfaceFactory;
    protected $orderRepository;
    protected $statusCollection;
    protected $orderStatusCollectionFactory;
    protected $orderStatusHistoryRepository;
    protected $cexCustomeroptionRepository;
    protected $cexEnviobultosRepository;
    protected $cexEnvioCronFactory;
    protected $cexEnvioCronRepository;
    protected $cexHistoryFactory;
    protected $cexHistoryRepository;
    protected $cexMigrationFactory;
    protected $cexMigrationRepository;
    protected $cexOfficedeliverycorreoRepository;
    protected $cexRespuestaCronFactory;
    protected $cexRespuestaCronRepository;
    protected $cexSavedshipFactory;
    protected $cexSavedshipRepository;
    protected $orderCollectionFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param PageFactory $pageFactory
     * @param Session $authSession
     * @param Json $json
     * @param ResourceInterface $resourceInterface
     * @param ModuleDataSetupInterface $setup
     * @param State $state
     * @param Resolver $resolverStore
     * @param StoreManagerInterface $storeManagerInterface
     * @param DateTime $dateTime
     * @param ResourceConnection $resource
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param OrderStatusCollection $statusCollection
     * @param OrderStatusCollectionFactory $orderStatusCollectionFactory
     * @param OrderStatusHistoryRepository $orderStatusHistoryRepository
     * @param OrderInterfaceFactory $orderInterfaceFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param CexCustomeroptionRepositoryInterface $cexCustomeroptionRepository
     * @param CexEnviobultosRepositoryInterface $cexEnviobultosRepository
     * @param CexEnvioCronInterfaceFactory $cexEnvioCronFactory
     * @param CexEnvioCronRepositoryInterface $cexEnvioCronRepository
     * @param CexHistoryInterfaceFactory $cexHistoryFactory
     * @param CexHistoryRepositoryInterface $cexHistoryRepository
     * @param CexMigrationInterfaceFactory $cexMigrationFactory
     * @param CexMigrationRepositoryInterface $cexMigrationRepository
     * @param CexOfficedeliverycorreoRepositoryInterface $cexOfficedeliverycorreoRepository
     * @param CexRespuestaCronInterfaceFactory $cexRespuestaCronFactory
     * @param CexRespuestaCronRepositoryInterface $cexRespuestaCronRepository
     * @param CexSavedshipInterfaceFactory $cexSavedshipFactory
     * @param CexSavedshipRepositoryInterface $cexSavedshipRepository
     * @param OrderCollectionFactory $orderCollectionFactory
     */

    public function __construct(
        Context                                    $context,
        JsonFactory                                $resultJsonFactory,
        PageFactory                                $pageFactory,
        Session                                    $authSession,
        Json                                       $json,
        ResourceInterface                          $resourceInterface,
        ModuleDataSetupInterface                   $setup,
        State                                      $state,
        Resolver                                   $resolverStore,
        StoreManagerInterface                      $storeManagerInterface,
        DateTime                                   $dateTime,
        ResourceConnection                         $resource,
        FilterBuilder                              $filterBuilder,
        SortOrderBuilder                           $sortOrderBuilder,
        SearchCriteriaBuilder                      $searchCriteriaBuilder,
        ScopeConfigInterface                       $scopeConfig,
        OrderStatusCollection                      $statusCollection,
        OrderStatusCollectionFactory               $orderStatusCollectionFactory,
        OrderStatusHistoryRepository               $orderStatusHistoryRepository,
        OrderInterfaceFactory                      $orderInterfaceFactory,
        OrderRepositoryInterface                   $orderRepository,
        CexCustomeroptionRepositoryInterface       $cexCustomeroptionRepository,
        CexEnviobultosRepositoryInterface          $cexEnviobultosRepository,
        CexEnvioCronInterfaceFactory               $cexEnvioCronFactory,
        CexEnvioCronRepositoryInterface            $cexEnvioCronRepository,
        CexHistoryInterfaceFactory                 $cexHistoryFactory,
        CexHistoryRepositoryInterface              $cexHistoryRepository,
        CexMigrationInterfaceFactory               $cexMigrationFactory,
        CexMigrationRepositoryInterface            $cexMigrationRepository,
        CexOfficedeliverycorreoRepositoryInterface $cexOfficedeliverycorreoRepository,
        CexRespuestaCronInterfaceFactory           $cexRespuestaCronFactory,
        CexRespuestaCronRepositoryInterface        $cexRespuestaCronRepository,
        CexSavedshipInterfaceFactory               $cexSavedshipFactory,
        CexSavedshipRepositoryInterface            $cexSavedshipRepository,
        OrderCollectionFactory                     $orderCollectionFactory
    )
    {
        $this->json = $json;
        $this->state = $state;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->setup = $setup;
        $this->authSession = $authSession;
        $this->_pageFactory = $pageFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->resolverStore = $resolverStore;
        $this->dateTime = $dateTime;
        $this->_resource = $resource;
        $this->_resourceInterface = $resourceInterface;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->statusCollection = $statusCollection;
        $this->orderInterfaceFactory = $orderInterfaceFactory;
        $this->orderRepository = $orderRepository;
        $this->orderStatusCollectionFactory = $orderStatusCollectionFactory;
        $this->orderStatusHistoryRepository = $orderStatusHistoryRepository;
        $this->cexCustomeroptionRepository = $cexCustomeroptionRepository;
        $this->cexEnviobultosRepository = $cexEnviobultosRepository;
        $this->cexEnvioCronFactory = $cexEnvioCronFactory;
        $this->cexEnvioCronRepository = $cexEnvioCronRepository;
        $this->cexHistoryFactory = $cexHistoryFactory;
        $this->cexHistoryRepository = $cexHistoryRepository;
        $this->cexMigrationFactory = $cexMigrationFactory;
        $this->cexMigrationRepository = $cexMigrationRepository;
        $this->cexOfficedeliverycorreoRepository = $cexOfficedeliverycorreoRepository;
        $this->cexRespuestaCronFactory = $cexRespuestaCronFactory;
        $this->cexRespuestaCronRepository = $cexRespuestaCronRepository;
        $this->cexSavedshipFactory = $cexSavedshipFactory;
        $this->cexSavedshipRepository = $cexSavedshipRepository;
        $this->orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_pageFactory->create();
    }

    public function getJsonEncode($result)
    {
        return $this->json->serialize($result);
    }

    public function getJsonDecode($string)
    {
        if ($this->is_serialized($string)) {
            $string = $this->json->serialize($string);
        }
        $result = json_decode($string, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Unable to unserialize value.');
        }
        return $result;
    }

    public function is_serialized($value, &$result = null)
    {
        if (!is_string($value)) {
            return false;
        }
        if ($value === 'b:0;') {
            $result = false;
            return true;
        }
        $length = strlen($value);
        $end = '';
        switch ($value[0]) {
            case 's':
                if ($value[$length - 2] !== '"') {
                    return false;
                }
            case 'b':
            case 'i':
            case 'd':
                $end .= ';';
            case 'a':
            case 'O':
                $end .= '}';
                if ($value[1] !== ':') {
                    return false;
                }
                switch ($value[2]) {
                    case 0:
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                        break;
                    default:
                        return false;
                }
            case 'N':
                $end .= ';';
                if ($value[$length - 1] !== $end[0]) {
                    return false;
                }
                break;
            default:
                return false;
        }
        if (($result = @getJsonDecode($value)) === false) {
            $result = null;
            return false;
        }
        return true;
    }

    public function retornarVersionModulo()
    {
        return $this->_resourceInterface->getDbVersion('CorreosExpress_RegistroDeEnvios');
    }

    public function cexEncryptDecrypt($action, $pass)
    {
        $nP = false;
        $saltText = $this->getCustomerOptionsClave('MXPS_CRYPT');
        $encrypt_method = 'AES-256-CBC';
        $salt = base64_decode($saltText);
        $salt1 = hash('sha256', $salt);
        $salt2 = substr(hash('sha256', $salt), 0, 16);
        if ($action == 'encrypt') {
            $nP = base64_encode(openssl_encrypt($pass, $encrypt_method, $salt1, 0, $salt2));
        } else if ($action == 'decrypt') {
            $nP = openssl_decrypt(base64_decode($pass), $encrypt_method, $salt1, 0, $salt2);
        }
        return $nP;
    }

    public function getUserCredentials()
    {

        $usuario = $this->getCustomerOptionsClave('MXPS_USER');
        $password = $this->getCustomerOptionsClave('MXPS_PASSWD');

        return [
            'usuario' => $this->cexEncryptDecrypt('decrypt', $usuario),
            'password' => $this->cexEncryptDecrypt('decrypt', $password)
        ];
    }

    public function getCustomerOptions()
    {
        $retorno = [];
        $data = $this->cexCustomeroptionRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($data as $item) {
            $clave = $item->getClave();
            $valor = $item->getValor();
            $retorno[$clave] = trim($valor);
        }
        return $retorno;
    }

    public function getCustomerOptionsClave($clave)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('clave', $clave, 'eq')
            ->create();

        $valor = $this->cexCustomeroptionRepository
            ->getList($searchCriteria)
            ->getItems();

        $valor = reset($valor);
        return  $valor->getValor();
    }

    public function getIdMetodoPago($nombreModulo, $id_contrarembolso)
    {
        if (!empty($id_contrarembolso) && strcmp($id_contrarembolso, 'Ninguno') !== 0) {
            if (strcmp($id_contrarembolso, $nombreModulo) == 0) {
                return $nombreModulo;
            }
        }
        return null;
    }

    public function comprobarContrareembolso($id)
    {
        $order = $this->retornarOrdenById($id);
        $payment_method_code = $order->getPayment()
            ->getMethodInstance()
            ->getCode();
        $defaultPayback = $this->getCustomerOptionsClave('MXPS_DEFAULTPAYBACK');
        $comprobante = $this->getIdMetodoPago($payment_method_code, $defaultPayback);

        if ($comprobante != null) {
            $contrareembolso = $order->getGrandTotal();
            $contrareembolso = round($contrareembolso, 2);
        } else {
            $contrareembolso = null;
        }
        return $contrareembolso;
    }

    public function retornarPesoPedido($id, $kilos = 0)
    {
        if ($kilos != 0) {
            return $kilos;
        }
        $order = $this->retornarOrdenById($id);
        $pesoOrden = $order->getWeight();
        $enableWeight = $this->getCustomerOptionsClave('MXPS_ENABLEWEIGHT');
        $defaultKg = $this->getCustomerOptionsClave('MXPS_DEFAULTKG');

        if ($enableWeight == "true") {
            if ($defaultKg == "") {
                $defaultKg = 1;
            }
            return $defaultKg;
        } else {
            if ($pesoOrden > 0) {
                $pesoTotal = round($pesoOrden, 2);
                return number_format($pesoTotal, 2);
            } else {
                return 1;
            }
        }
    }

    public function retornarDatosOficina($id)
    {
        $order = $this->retornarOrdenById($id);
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('id_cart', $order->getQuoteId(), 'eq')
            ->create();

        $results = $this->cexOfficedeliverycorreoRepository
            ->getList($searchCriteria)
            ->getItems();
        $results = reset($results);

        if ($results) {
            $row_data_ofi['codigo_oficina'] = str_pad($results->getCodigoOficina(), 7, '0', STR_PAD_LEFT);
            $row_data_ofi['texto_oficina']  = $results->getTextoOficina();
            $row_data_ofi['id_order']       = $id;
            return $row_data_ofi;
        } else {
            return false;
        }
    }

    public function comprobarIdpedidoNumShip($numcollect, $type)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('type', $type)
            ->addFilter('num_collect', $numcollect)
            ->addFilter('status', 'Grabado')
            ->addFilter('deleted_at', '', 'null')
            ->create();

        $results = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();        
        if (empty($results) || is_null($results)) {
            return true;
        } 
        return false;
        
    }

    public function cexGuardarSavedships($datos, $num_ship, $type = '')
    {
        $tipo_peticion = 'create';

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('type', $type)
            ->addFilter('num_collect', $datos['ref_ship'])
            ->addFilter('deleted_at', '', 'null')
            ->create();

        $orderSavedShip = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        if (!empty($orderSavedShip)) {
            $orderSavedShip = reset($orderSavedShip);
            $ship_id = $orderSavedShip->getSavedShipsId();
            $tipo_peticion = 'update';
        }

        switch ($tipo_peticion) {
            case 'create':
                $cexSavedshipNew = $this->poblarNewSavedShip($this->cexSavedshipFactory->create(), $datos, $num_ship, $type);
                $this->cexSavedshipRepository->save($cexSavedshipNew);
                break;
            case 'update':
                $cexSavedshipPersistido = $this->cexSavedshipRepository->getById($ship_id);
                $this->poblarNewSavedShip($cexSavedshipPersistido, $datos, $num_ship, $type);
                $this->cexSavedshipRepository->save($cexSavedshipPersistido);
                break;
        }

        if ($this->getCustomerOptionsClave('MXPS_SAVEDSTATUS') == 'true') {
            $estado = $this->getCustomerOptionsClave('MXPS_RECORDSTATUS');
            $this->cambiarEstadoOrder($datos['id'], $estado);
        }
    }

    private function poblarNewSavedShip($cexSavedshipNew, $datos, $num_ship, $type)
    {
        $referenciaCliente = $this->retornarId($datos['id']);
        $ordenObj = $this->retornarOrdenByid($referenciaCliente);
        $orden = $ordenObj->getData();
        $numcollect = $datos['ref_ship'];
        $devolucion = 0;
        $status = 'Grabado';
        $entrega_sabado = 0;

        if ($datos['loadReceiver'] == 'true') {
            $devolucion = 1;
        }

        if ($datos['deliver_sat'] == 'true') {
            $entrega_sabado = 1;
        }

        if (is_null($num_ship)) {
            $num_ship = '';
        }
        $cexSavedshipNew->setDate($datos['datepicker']);
        $cexSavedshipNew->setIdBc(intval($datos['selCarrier']));
        $cexSavedshipNew->setNumCollect($numcollect);
        $cexSavedshipNew->setNumShip($num_ship);
        $cexSavedshipNew->setCollectFrom($datos['name_sender']);
        $cexSavedshipNew->setIdOrder($orden['entity_id']);
        $cexSavedshipNew->setIdMode(0);
        $cexSavedshipNew->setIdSender(intval($datos['loadSender']));
        $cexSavedshipNew->setType($type);
        $cexSavedshipNew->setKg($this->calcularPesoEnKilos($datos['kilos']));
        $cexSavedshipNew->setIndsuredValue(floatval($datos['insured_value']));
        $cexSavedshipNew->setPackage(intval($datos['bultos']));
        $cexSavedshipNew->setPaybackVal(floatval($datos['payback_val']));
        $cexSavedshipNew->setPostalCode($datos['postcode_sender']);
        $cexSavedshipNew->setModeShipName($datos['nombre_modalidad']);
        $cexSavedshipNew->setStatus($status);
        // A 0 por desuso
        $cexSavedshipNew->setIdShipExpired(0);
        $cexSavedshipNew->setIdGroup(0);
        $cexSavedshipNew->setNoteCollect($datos['note_collect']);
        $cexSavedshipNew->setNoteDeliver($datos['note_deliver']);
        $cexSavedshipNew->setIsoCode($datos['iso_code']);
        $cexSavedshipNew->setDevolution($devolucion);
        $cexSavedshipNew->setDeliverSat($entrega_sabado);
        $cexSavedshipNew->setMailLabel(0);
        $cexSavedshipNew->setDescRef1($datos['desc_ref_1']);
        $cexSavedshipNew->setDescRef2($datos['desc_ref_2']);
        $cexSavedshipNew->setFromHour(intval($datos['fromHH_sender']));
        $cexSavedshipNew->setToHour(intval($datos['toHH_sender']));
        $cexSavedshipNew->setToMinute(intval($datos['toMM_sender']));
        $cexSavedshipNew->setFromMinute(intval($datos['fromMM_sender']));
        $cexSavedshipNew->setSenderName($datos['name_sender']);
        $cexSavedshipNew->setSenderContact($datos['contact_sender']);
        $cexSavedshipNew->setSenderAddress($datos['address_sender']);
        $cexSavedshipNew->setSenderPostCode($datos['postcode_sender']);
        $cexSavedshipNew->setSenderCity($datos['city_sender']);
        $cexSavedshipNew->setSenderPhone($datos['phone_sender']);
        $cexSavedshipNew->setSenderCountry($datos['country_sender']);
        $cexSavedshipNew->setSenderEmail($datos['contact_sender']);
        $cexSavedshipNew->setReceiverName($datos['name_receiver']);
        $cexSavedshipNew->setReceiverContact($datos['contact_receiver']);
        $cexSavedshipNew->setReceiverAddress($datos['address_receiver']);
        $cexSavedshipNew->setReceiverPostCode($datos['postcode_receiver']);
        $cexSavedshipNew->setReceiverCity($datos['city_receiver']);
        $cexSavedshipNew->setReceiverPhone(intval($datos['phone_receiver1']));
        $cexSavedshipNew->setReceiverPhone2(intval($datos['phone_receiver2']));
        $cexSavedshipNew->setReceiverCountry($this->getCountryByIsoCode($datos['country_receiver']));
        $cexSavedshipNew->setReceiverEmail($datos['email_receiver']);
        $cexSavedshipNew->setCodigoCliente($datos['codigo_cliente']);
        $cexSavedshipNew->setOficinaEntrega($datos['text_oficina']);
        $cexSavedshipNew->setWsEstadoTracking(0);
        $cexSavedshipNew->setModificacionAutomatica(0);
        $cexSavedshipNew->setAtPortugal(is_null($datos['at_portugal']) ? '' : $datos['at_portugal']);
        return $cexSavedshipNew;
    }

    public function deleteSavedShip($numcollect = false)
    {
        if (isset($_POST['numcollect']) && $_POST['numcollect'] != '') {
            $numcollect = $_POST['numcollect'];
        }
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('num_collect', $numcollect)
            ->create();

        $savedShipList = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($savedShipList as $savedShip) {
            $savedShip->setDeletedAt(date('Y-m-d H:i:s'));
            $this->cexSavedshipRepository->save($savedShip);
        }

        $bultosList = $this->cexEnviobultosRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($bultosList as $bulto) {
            $bulto->setDeletedAt(date('Y-m-d H:i:s'));
            $this->cexEnviobultosRepository->save($bulto);
        }
    }

    public function deleteMultipleSavedShips($ordenes)
    {

        $filter[] = $this->filterBuilder
            ->setField('num_collect')
            ->setValue($ordenes)
            ->setConditionType('in')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilters($filter)
            ->create();

        $savedShipList = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($savedShipList as $savedShip) {
            $savedShip->setDeletedAt(date('Y-m-d H:i:s'));

            $this->cexSavedshipRepository->save($savedShip);
        }

        $bultosList = $this->cexEnviobultosRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($bultosList as $bulto) {
            $bulto->setDeletedAt(date('Y-m-d H:i:s'));

            $this->cexEnviobultosRepository->save($bulto);
        }
    }

    public function deleteSavedShipByNumShip($numship)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('num_ship', $numship)
            ->create();

        $savedShipList = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($savedShipList as $savedShip) {
            $savedShip->setDeletedAt(date('Y-m-d H:i:s'));
            $this->cexSavedshipRepository->save($savedShip);
        }

        $bultosList = $this->cexEnviobultosRepository
            ->getList($searchCriteria)
            ->getItems();

        foreach ($bultosList as $bulto) {
            $bulto->setDeletedAt(date('Y-m-d H:i:s'));
            $this->cexEnviobultosRepository->save($bulto);
        }
    }

    public function obtenerOrdenByNumCollect($num_collect)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('num_collect', $num_collect)
            ->addFilter('deleted_at', '', 'null')
            ->create();

        return $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();
    }

    public function obtenerPedidoByNumShip($num_ship)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('num_ship', $num_ship)
            ->create();

        $savedShip = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        return reset($savedShip);
    }

    public function obtenerOrder_idFromNum_ship($num_ship)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('num_ship', $num_ship)
            ->create();

        $savedShip = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();

        $savedShip = reset($savedShip);
        return $savedShip->getIdOrder();
    }

    public function cambiarEstadoOrder($id_order, $status)
    {
        $id             = $this->retornarId($id_order);
        $order          = $this->retornarOrdenById($id);
        $orderStatus    = $order->getStatus();

        if (strcmp($status, $orderStatus) != 0) {
            $infoEstados    = $this->obtenerinfoStatus($status);
            $state          = $infoEstados[0]['state'];
            $label          = $infoEstados[0]['label'];
            $order->setState($state);
            $order->setStatus($status);
            $this->orderRepository->save($order);
            $history        = $order->addCommentToStatusHistory('Order changes to : ' . $label, $order->getStatus());
            $history->setIsCustomerNotified(true);
            $this->orderStatusHistoryRepository->save($history);
        }
    }

    public function obtenerinfoStatus($status)
    {
        return $this->orderStatusCollectionFactory
            ->create()
            ->joinStates()
            ->addFieldToFilter('main_table.status', $status)
            ->getData();
    }

    public function cexRellenarCeros($valor, $longitud)
    {
        return str_pad($valor, $longitud, '0', STR_PAD_LEFT);
    }

    public function obtenerIdiomaTienda()
    {
        $idioma = $this->resolverStore->getLocale();
        $res = "ES";
        if (!strcmp($idioma, "es_ES") == 0) {
            $res = "PT";
        }
        return $res;
    }

    public function obtenerIdiomaUsuario()
    {
        $idioma = $this->authSession->getUser()->getInterfaceLocale();

        switch ($idioma) {
            case'en_GB':
                $res = "GB";
                break;
            case 'en_US':
                $res = "US";
                break;
            case 'ca_ES':
                $res = "CA";
                break;
            case 'es_ES':
                $res = "ES";
                break;
            case 'pt_PT':
                $res = "PT";
                break;
            default:
                $res = "ES";
                break;
        }
        return $res;
    }

    public function calcularPesoEnKilos($peso)
    {
        $unidadMedida = $this->scopeConfig->getValue('general/locale/weight_unit');

        switch ($unidadMedida) {
            case 'lbs';
                $nuevoPeso = $peso * 0.453592;
                break;
            default:
                $nuevoPeso = $peso;
                break;
        }
        $data = ltrim($nuevoPeso);
        return round($data, 3, PHP_ROUND_HALF_UP);
    }


    public function comprobarCronAjax()
    {
        $tipoCron                   = $this->getCustomerOptionsClave('MXPS_CRONTYPE');
        if (strcmp('ajax', $tipoCron) == 0) {
            $currentDate            = $this->obtenerFechaActual();
            $searchCriteria         = $this->searchCriteriaBuilder
                                            ->addFilter('clave', 'MXPS_LASTCRONEXE', 'eq')
                                            ->create();

            $lastCronExe            = $this->cexCustomeroptionRepository
                                            ->getList($searchCriteria)
                                            ->getItems();
            $lastCronExe            = reset($lastCronExe);
            $ultimaEjecucion        = $lastCronExe->getValor();
            $fechaUltimaEjecucion   = strtotime($ultimaEjecucion);
            $fechaActual            = strtotime($currentDate);
            $diferencia             = $fechaActual - $fechaUltimaEjecucion;
            $horas                  = intval($diferencia / 3600);

            if ($horas > 3) {
                $this->ejecutarCexCron();
                $id             = intval($lastCronExe->getCustomerOptionsId());
                $lastCronExeDTO = $this->cexCustomeroptionRepository->getById($id);
                $lastCronExeDTO->setValor($currentDate);
                $this->cexCustomeroptionRepository->save($lastCronExeDTO);
            } else {
                switch ($horas) {
                    case 0:
                        echo 'Cron has been ran less than an hour ago';
                        break;
                    case 1:
                    case 2:
                        echo 'Cron will run in less than ' . (4 - $horas) . ' hour/s';
                        break;
                    case 3:
                        echo 'Cron will run in less than an hour';
                        break;
                }
            }
        }
    }

    public function getCountryByIsoCode($iso_code)
    {
        switch ($iso_code) {
            case 'PT':
            case 'Portugal':
                $response = 'Portugal';
                break;
            default:
                $response = 'España';
                break;
        }
        return $response;
    }

    public function obtenerFechaActual()
    {
        $timezone       = $this->storeManagerInterface
                                ->getStore()
                                ->getConfig('general/locale/timezone');
        date_default_timezone_set($timezone);
        $currentDate    = $this->dateTime
                                ->gmtDate();
        $fechaActual    = strtotime($currentDate);
        return date("Y-m-d H:i:s", $fechaActual);
    }

    public function retornarId($id)
    {
        $customRef      = $this->getCustomerOptionsClave('MXPS_REFETIQUETAS');
        $searchCriteria = $this->searchCriteriaBuilder
                                ->addFilter('entity_id', $id, 'eq')
                                ->create();

        $orderList      = $this->orderRepository
                                ->getList($searchCriteria)
                                ->getItems();
        $order          = reset($orderList);

        switch ($customRef) {
            case '1':
                $referencia = $order->getId();
                break;
            case '2':
                $referencia = $order->getIncrementId();
                break;
            default:
                break;
        }
        return $referencia;
    }

    public function retornarOrdenById($id)
    {
        $order = '';
        $customRef = $this->getCustomerOptionsClave('MXPS_REFETIQUETAS');
        switch ($customRef) {
            case '1':
                $searchCriteria = $this->searchCriteriaBuilder
                                        ->addFilter('entity_id', $id, 'eq')
                                        ->create();
                $orderList      = $this->orderRepository
                                        ->getList($searchCriteria)
                                        ->getItems();
                $order          = reset($orderList);
                break;
            case '2':
                $searchCriteria = $this->searchCriteriaBuilder
                                        ->addFilter('increment_id', $id, 'eq')
                                        ->create();
                $orderList      = $this->orderRepository
                                        ->getList($searchCriteria)
                                        ->getItems();
                $order          = reset($orderList);
                break;
        }
        return $order;
    }

    public function comprobar_ejecucion_migracion($nombre_migracion, $setup)
    {
        $searchCriteria     = $this->searchCriteriaBuilder
                                    ->addFilter('metodo_ejecutado', $nombre_migracion, 'eq')
                                    ->create();
        $migrationsCount    = $this->cexMigrationRepository
                                    ->getList($searchCriteria)
                                    ->getTotalCount();
        return intval($migrationsCount);
    }

    public function registrar_ejecucion_migracion($nombre_migracion, $setup)
    {
        $cexMigrationDTO = $this->cexMigrationFactory->create();
        $cexMigrationDTO->setMetodoEjecutado($nombre_migracion);
        $this->cexMigrationRepository->save($cexMigrationDTO);
    }

    public function cex_cron_customer_options(){
        $claves = array('MXPS_TRACKINGCEX', 'MXPS_SENDINGSTATUS', 'MXPS_CANCELEDSTATUS', 'MXPS_CHANGESTATUS', 'MXPS_RETURNEDSTATUS', 'MXPS_DELIVEREDSTATUS', 'MXPS_RECORDSTATUS');

        $filters[]      = $this->filterBuilder
                            ->setField('clave')
                            ->setValue($claves)
                            ->setConditionType('in')
                            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
                            ->addFilters($filters)
                            ->create();

        $opcionesCron   = $this->cexCustomeroptionRepository
                            ->getList($searchCriteria)
                            ->getItems();

        $retorno = [];
        foreach ($opcionesCron as $item) {
            $clave = $item->getClave();
            $valor = $item->getValor();
            $retorno[$clave] = trim($valor);
        }

        return $retorno;

    }

    public function ejecutarCexCron()
    {
        $this->resetearTablasCron();
        $opciones = $this->cex_cron_customer_options();
        $tracking = $opciones['MXPS_TRACKINGCEX'];

        $nombreTabla = $this->_resource->getTableName('correosexpress_registrodeenvios_cexsavedships');
        $date = $this->obtenerFechaActual();

        $i = 0;
        echo "<br>Fecha de inicio => " . $date . PHP_EOL;
        if ($tracking) {
            $sql = "SELECT distinct p2.codigo_cliente
                        FROM (SELECT  id_order, MAX(ship_id) AS id
                                FROM $nombreTabla
                                WHERE type = 'Envio'
                                GROUP BY id_order
                                ORDER BY ship_id DESC) p1
                        JOIN $nombreTabla p2
                        ON p1.id = p2.ship_id
                        WHERE TIMESTAMPDIFF(MONTH, updated_at, NOW()) < 1
                        AND num_ship !=''
                        AND (ws_estado_tracking != 12 &&
                        ws_estado_tracking != 13 &&
                        ws_estado_tracking != 14 &&
                        ws_estado_tracking != 15 &&
                        ws_estado_tracking != 16 &&
                        ws_estado_tracking != 17 &&
                        ws_estado_tracking != 19 &&
                        ws_estado_tracking != 31)
                        AND p2.deleted_at is null
                        ORDER BY ship_id ASC
                        LIMIT 500";

            $readConnection = $this->_resource->getConnection('core_read');
            $codigos_cliente = $readConnection->fetchAll($sql);

            foreach ($codigos_cliente as $codigo_cliente) {
                $query = "SELECT p2.*
                            FROM (SELECT id_order, MAX(ship_id) AS id
                                    FROM $nombreTabla
                                    WHERE TYPE = 'Envio'
                                    GROUP BY id_order
                                    ORDER BY ship_id DESC) p1
                            JOIN $nombreTabla p2
                            ON p1.id = p2.ship_id
                            WHERE TIMESTAMPDIFF(MONTH, updated_at, NOW()) < 1
                            AND num_ship !=''
                            AND (ws_estado_tracking != 12 &&
                            ws_estado_tracking != 13 &&
                            ws_estado_tracking != 14 &&
                            ws_estado_tracking != 15 &&
                            ws_estado_tracking != 16 &&
                            ws_estado_tracking != 17 &&
                            ws_estado_tracking != 19 &&
                            ws_estado_tracking != 31)
                            AND p2.codigo_cliente = '" . $codigo_cliente["codigo_cliente"] . "'
                            AND deleted_at is null
                            ORDER BY ship_id ASC
                            LIMIT 500";

                $readConnection = $this->_resource->getConnection('core_read');
                $ordenes = $readConnection->fetchAll($query);

                if (!empty($ordenes)) {
                    $rest       = $this->cexEnviarPeticionTracking($ordenes);
                    $curl       = $this->procesarCurlSeguimiento($rest);
                    $retorno    = json_decode($curl, true);

                    $cexEnvioCronNew = $this->cexEnvioCronFactory->create();
                        $cexEnvioCronNew->setPeticionEnvio($rest["peticion"]);
                        $cexEnvioCronNew->setRespuestaEnvio($curl);
                        $cexEnvioCronNew->setCodError($retorno['codError']);
                        $cexEnvioCronNew->setDescError($retorno['desError']);
                        $cexEnvioCronNew->setCodCliente($codigo_cliente["codigo_cliente"]);
                        $cexEnvioCronNew->setCreatedAt($date);
                    $this->cexEnvioCronRepository->save($cexEnvioCronNew);

                    $cexEnvioCronData = $this->cexEnvioCronRepository->getById($cexEnvioCronNew->getId());
                    $id_envio_cron = $cexEnvioCronData['id_envio_cron'];


                    foreach ($retorno['listaEnvios'] as $orden) {
                        if (is_null($orden['codigoEstado'])) {
                            if ($opciones['MXPS_CHANGESTATUS'] == "true") {
                                $id_order = $this->obtenerOrder_idFromNum_ship($orden['nEnvio']);
                                $this->cambiarEstadoOrder($id_order, $opciones['MXPS_CANCELEDSTATUS']);
                                echo "Estado de la orden => " . $id_order . " ha cambiado a => Cancelado <br>";
                                $this->actualizarEstadoSavedShips($orden['nEnvio'], 19, 'Anulado');
                            }
                        } else {
                            $estadoAntiguo = $this->cexBuscarEstadoOrdenByNumship($orden['nEnvio'], $ordenes);
                            $this->cexProcesarOrdenTracking($orden, $opciones, $estadoAntiguo);
                            $i++;
                            $cexRespuestaCronNew = $this->cexRespuestaCronFactory->create();
                                $cexRespuestaCronNew->setNEnvio($orden['nEnvio']);
                                $cexRespuestaCronNew->setReferencia($orden['referencia']);
                                $cexRespuestaCronNew->setCodIncidencia($orden['codigoIncidencia']);
                                $cexRespuestaCronNew->setDescIncidencia($orden['descripcionIncidencia']);
                                $cexRespuestaCronNew->setCodEstado($orden['codigoEstado']);
                                $cexRespuestaCronNew->setDescEstado($orden['descripcionEstado']);
                                $cexRespuestaCronNew->setcodCliente($codigo_cliente['codigo_cliente']);
                                $cexRespuestaCronNew->setEstadoAntiguo($estadoAntiguo);
                                $cexRespuestaCronNew->setCreatedAt($date);
                                $cexRespuestaCronNew->setIdEnvioCron($id_envio_cron);
                                $cexRespuestaCronNew->save();
                            $this->cexRespuestaCronRepository->save($cexRespuestaCronNew);
                        }
                    }
                } else {
                    echo "No existen ordenes para comprobar";
                }
            }
        } else {
            echo "CRON DESACTIVADO";
        }
        echo "<br>Finalizando cron, número de ordenes ejecutadas => " . $i . PHP_EOL;
        echo "<br>Finalizada cron_cex_function con exito<br>";
    }

    public function resetearTablasCron()
    {
        $itemsRespuesta = $this->cexRespuestaCronRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($itemsRespuesta as $itemRespuesta) {
            $this->cexRespuestaCronRepository
                ->deleteById($itemRespuesta->getIdRespuestaCron());
        }

        $itemsEnvio = $this->cexEnvioCronRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($itemsEnvio as $itemEnvio) {
            $this->cexEnvioCronRepository
                ->delete($itemEnvio);
        }
    }

    public function cexProcesarOrdenTracking($orden, $opciones, $estadoTrackingBBDD)
    {
        $num_ship           = $orden['nEnvio'];
        $cambiar_estado     = $opciones['MXPS_CHANGESTATUS'];
        $respuesta_tracking = $orden['codigoEstado'];
        $esAnulado          = $this->esAnulado($respuesta_tracking);
        $estaEnCurso        = $this->estaEnCurso($respuesta_tracking);
        $id_order           = $this->obtenerOrder_idFromNum_ship($num_ship);

        echo "Orden id => " . $id_order;
        echo "<br>  La respuesta del WS ha sido " . $respuesta_tracking . "<br>";

        if ($cambiar_estado == true) {
            if ($respuesta_tracking == '1') {
                $this->cambiarEstadoOrder($id_order, $opciones['MXPS_RECORDSTATUS']);
                $this->actualizarEstadoSavedShips($num_ship, $respuesta_tracking, 'Grabado');
            } elseif ($estaEnCurso == true) {
                // ESTADO ENVIADO CEX
                $this->cambiarEstadoOrder($id_order, $opciones['MXPS_SENDINGSTATUS']);
                echo "Estado de la orden => " . $id_order . " ha cambiado a => Enviado<br>";
                $this->actualizarEstadoSavedShips($num_ship, $respuesta_tracking, 'Enviado');
            } elseif ($esAnulado == true) {
                // ESTADO ANULADO CEX
                $this->cambiarEstadoOrder($id_order, $opciones['MXPS_CANCELEDSTATUS'], "Anulado Cex");
                echo "Estado de la orden => " . $id_order . " ha cambiado a => Cancelado <br>";
                $this->actualizarEstadoSavedShips($num_ship, $respuesta_tracking, 'Anulado');
            } elseif ($respuesta_tracking == '17') {
                // ESTADO DEVUELTO CEX
                $this->cambiarEstadoOrder($id_order, $opciones['MXPS_RETURNEDSTATUS'], "Devuelto Cex");
                echo "estado de la orden => " . $id_order . " ha cambiado a => Devuelto<br>";
                $this->actualizarEstadoSavedShips($num_ship, $respuesta_tracking, 'Devuelto');
            } elseif ($respuesta_tracking == '12') {
                //COMPLETADO CEX
                $this->cambiarEstadoOrder($id_order, $opciones['MXPS_DELIVEREDSTATUS'], "Completado Cex");
                echo "estado de la orden => " . $id_order . " ha cambiado a => Completado<br>";
                $this->actualizarEstadoSavedShips($num_ship, $respuesta_tracking, 'Completado');
            } else {
                echo "estado de la orden => " . $id_order . " no ha cambiado";
            }
        } else {
            echo "CAMBIO DE ESTADO DESACTIVADO \n";
        }
    }

    public function esAnulado($respuesta_tracking)
    {
        $arrayAnulados = array(13, 14, 15, 16, 19);
        return is_numeric(array_search($respuesta_tracking, $arrayAnulados));
    }

    public function estaEnCurso($respuesta_tracking)
    {
        $arrayEncurso = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 18, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42);
        return is_numeric(array_search($respuesta_tracking, $arrayEncurso));
    }

    public function cexBuscarEstadoOrdenByNumship($numship, $arrayBBDD)
    {
        $retorno = "";
        foreach ($arrayBBDD as $orden) {
            if (strcmp($numship, $orden['num_ship']) == 0) {
                $retorno = $orden['ws_estado_tracking'];
            }
        }
        return $retorno;
    }

    public function actualizarEstadoSavedShips($num_ship, $respuesta_tracking, $status)
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('type', 'Envio')
            ->addFilter('num_ship', $num_ship)
            ->create();

        $savedShipList = $this->cexSavedshipRepository
            ->getList($searchCriteria)
            ->getItems();
        $savedShip = reset($savedShipList);
        $savedShip->setWsEstadoTracking($respuesta_tracking);
        $savedShip->setStatus($status);
        $this->cexSavedshipRepository->save($savedShip);
    }

    public function cexEnviarPeticionTracking($ordenes)
    {
        $url            = $this->getCustomerOptionsClave('MXPS_WSURLSEG');
        $codigo_cliente = $ordenes[0]['codigo_cliente'];
        $codigo_cliente = substr($codigo_cliente, 0, 5);
        $lista          = array();
        foreach ($ordenes as $orden) {
            $num_ship = $orden['num_ship'];
            if ($num_ship != "") {
                array_push($lista, $num_ship);
            }
        }
        $rest_request = array(
            "codigoCliente" => $codigo_cliente,
            "nEnvios" => $lista,
            "idioma" => $this->obtenerIdiomaUsuario()
        );
        return [
            'peticion' => $this->getJsonEncode($rest_request),
            'url' => $url
        ];
    }

    public function procesarCurlSeguimiento($peticion)
    {

        $credenciales = $this->getUserCredentials();

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

    public function retornarNombresProductos($id_order)
    {
        $retorno                = "";
        $concatenados           = $this->getInfoOrderProducts($id_order);
        $noDataProtection       = $this->getCustomerOptionsClave('MXPS_NODATAPROTECTION');
        $noDataProtectionValue  = $this->getCustomerOptionsClave('MXPS_DATAPROTECTIONVALUE');

        if ($noDataProtection == "true") {
            foreach ($concatenados['productos'] as $producto) {
                switch ($noDataProtectionValue) {
                    case 2:
                        $retorno = $concatenados['nameProducts'];
                        break;
                    case 3:
                        $retorno = '';
                        break;
                    case 4:
                        $retorno = $concatenados['skuProducts'];
                        break;
                    default :
                        $retorno = $concatenados['idProducts'];
                        break;
                }
            }
        }
        return $retorno;
    }

    private function getInfoOrderProducts($id_order)
    {
        $count          = 1;
        $delimitador    = ', ';
        $concatenados   = [
            'productos'     => [],
            'nameProducts'  => '',
            'idProducts'    => '',
            'skuProducts'   => '',
        ];

        $quote_item_table   = $this->_resource->getTableName('quote_item');
        $orderCollection    = $this->orderCollectionFactory->create();
        $select             = $orderCollection->getSelect();
        $select->joinLeft(
            ["qo" => $quote_item_table],
            'main_table.quote_id = qo.quote_id'
        );
        $select->where('main_table.entity_id = ' . $id_order);
        $select->where('qo.product_type = "simple"');
        $productos          = $orderCollection->getData();

        $concatenados['productos'] = $productos;
        foreach ($productos as $producto) {
            if ($count < count($productos)) {
                $concatenados['nameProducts'] .= '#' . $producto['name'] . ' (' . (int)$producto['qty'] . ')' . $delimitador;
                $concatenados['idProducts'] .= 'Ref#' . $producto['product_id'] . $delimitador;
                $concatenados['skuProducts'] .= '#' . $producto['sku'] . $delimitador;
            } else {
                $concatenados['nameProducts'] .= '#' . $producto['name'] . ' (' . (int)$producto['qty'] . ')';
                $concatenados['idProducts'] .= 'Ref#' . $producto['product_id'];
                $concatenados['skuProducts'] .= '#' . $producto['sku'];
            }
            $count++;
        }
        return $concatenados;
    }

    public function getHttpStatusMessage($status_code)
    {
        switch ($status_code) {
            case '200':
                return 'OK';
            case '400':
                return 'Bad Request';
            case '401':
                return 'UnAuthorized';
            case '404':
                return 'Not Found';
            case '500':
                return 'Internal Web Service Error';
            default:
                return 'Web Service Error';
        }
    }

    function crearError($id_order, $num_collect, $decripcion_error, $codigo_error)
    {
        return [
            'codigo_error'      => $codigo_error,
            'decripcion_error'  => $decripcion_error,
            'id_order'          => $id_order,
            'num_collect'       => $num_collect
        ];
    }

    function pintarErroresMasiva($errores, $nombreTabla, $tipoReimpresion)
    {
        $titulo             = __('Gestiona los errores de tu pedido');
        $literalIdOrden     = __('ID ORDEN');
        $literalMensaje     = __('MENSAJE');
        $literalEnlace      = __('IR AL PEDIDO ');
        $literalEnlaceError = __('ERROR GENERAL');

        $cabecera = "<h4>" . $titulo . "</h4>";
        $cabecera .= "<table id='" . $nombreTabla . "' class='table w-100'>" .
            "<thead><tr>" .
            "<th>" . $literalIdOrden . " </th>" .
            "<th>" . $literalMensaje . " </th>" .
            "<th>" . $literalEnlace . "  </th>" .
            "</tr></thead>";
        $finTabla = "</table>";
        $contenido = "<tbody>";

        foreach ($errores as $error) {
            if ($tipoReimpresion == 2) {
                return $error['decripcion_error'];
            }
            if ($error['id_order'] != 0) {
                $url = $this->getUrl('sales/order/view', ['order_id' => $error['id_order']]);
                $enlace = "<a href=" . $url . " target='_blank'>" . $literalEnlace . $error['id_order'] . "</a>";
            } else {
                $enlace = "<span class='enlaceReimpresionTachado'>" . $literalEnlaceError . " </span>";
            }
            $contenido .= "<tr><td id='introJS" . $nombreTabla . "IdOrder'>" . $error['id_order'] . "</td><td id='introJS" . $nombreTabla . "Mensaje'>" . $error['codigo_error'] . " - " . $error['decripcion_error'] . "</td><td id='introJS" . $nombreTabla . "Enlace'>" . $enlace . "</td></tr>";
        }
        $contenido .= "</tbody>";
        $footer = "<tfoot><tr>" .
            "<th>" . $literalIdOrden . " </th>" .
            "<th>" . $literalMensaje . " </th>" .
            "<th>" . $literalEnlace . "  </th>" .
            "</tr></tfoot>";
        return $cabecera . $contenido . $footer . $finTabla;
    }

    function cexGuardarHistorico($id_order,
                                 $num_collect,
                                 $type,
                                 $num_ship,
                                 $fecha,
                                 $resultado,
                                 $mensaje,
                                 $cod_ret,
                                 $envio_wsString,
                                 $respuesta_ws,
                                 $producto = NULL,
                                 $modeShipName = NULL,
                                 $fechaRec = NULL,
                                 $horaDesde = NULL,
                                 $horaHasta = NULL)
    {
        $cexHistoryNew = $this->cexHistoryFactory->create();
        $cexHistoryNew->setIdOrder($id_order);
        $cexHistoryNew->setNumCollect($num_collect);
        $cexHistoryNew->setType($type);
        $cexHistoryNew->setNumShip($num_ship);
        $cexHistoryNew->setFecha($fecha);
        $cexHistoryNew->setResultado($resultado);
        $cexHistoryNew->setMensajeRetorno($mensaje);
        $cexHistoryNew->setCodigoRetorno(intval($cod_ret));
        $cexHistoryNew->setEnvioWs($envio_wsString);
        $cexHistoryNew->setRespuestaWs($respuesta_ws);

        if ($producto != NULL) {
            $cexHistoryNew->setIdBcWs($producto);
            $cexHistoryNew->setModeShipNameWs($modeShipName);
        }
        if ($fechaRec != NULL) {
            $cexHistoryNew->setFechaRecogida($fechaRec);
            $cexHistoryNew->setHoraRecogidaDesde($horaDesde);
            $cexHistoryNew->setHoraRecogidaHasta($horaHasta);
        }

        $this->cexHistoryRepository->save($cexHistoryNew);
    }
}
