<?php

namespace CorreosExpress\RegistroDeEnvios\Controller\frontend;

use CorreosExpress\RegistroDeEnvios\Controller\Adminhtml\Helpers;
use Magento\Backend\App\Action\Context;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\View\Asset\Repository;

//CEX
//interface factory
use CorreosExpress\RegistroDeEnvios\Api\Data\CexOfficedeliverycorreoInterfaceFactory;

//Collection Factory
use CorreosExpress\RegistroDeEnvios\Model\ResourceModel\CexOfficedeliverycorreo\CollectionFactory as OfficedeliverycorreoCollectionFactory;

//Repository Interfaces
use CorreosExpress\RegistroDeEnvios\Api\CexOfficedeliverycorreoRepositoryInterface;

/**
 * Class Ajax
 */
class Ajax extends Action
{

    protected $formKey;
    protected $_cexHelpers;
    protected $_checkoutSession;
    protected $_assetRepo;
    protected $cexOfficedeliverycorreoFactory;
    protected $cexOfficedeliverycorreoCollectionFactory;
    protected $cexOfficedeliverycorreoRepository;


    /**
     * Create constructor.
     *
     * @param FormKey $formKey
     * @param Context $context
     * @param Repository $assetRepo
     * @param Session $checkoutSession
     * @param Helpers\Index $cexHelpers
     * @param CexOfficedeliverycorreoInterfaceFactory $cexOfficedeliverycorreoFactory
     * @param CexOfficedeliverycorreoRepositoryInterface $cexOfficedeliverycorreoRepository
     * @param OfficedeliverycorreoCollectionFactory $cexOfficedeliverycorreoCollectionFactory
     */
    public function __construct(
        FormKey                                    $formKey,
        Context                                    $context,
        Repository                                 $assetRepo,
        Session                                    $checkoutSession,
        Helpers\Index                              $cexHelpers,
        CexOfficedeliverycorreoInterfaceFactory    $cexOfficedeliverycorreoFactory,
        CexOfficedeliverycorreoRepositoryInterface $cexOfficedeliverycorreoRepository,
        OfficedeliverycorreoCollectionFactory      $cexOfficedeliverycorreoCollectionFactory)
    {
        $this->formKey = $formKey;
        $this->_cexHelpers = $cexHelpers;
        $this->_assetRepo = $assetRepo;
        $this->_checkoutSession = $checkoutSession;
        $this->cexOfficedeliverycorreoFactory = $cexOfficedeliverycorreoFactory;
        $this->cexOfficedeliverycorreoRepository = $cexOfficedeliverycorreoRepository;
        $this->cexOfficedeliverycorreoCollectionFactory = $cexOfficedeliverycorreoCollectionFactory;
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
            )
        );

        $output = curl_exec($ch);
        curl_close($ch);

        echo $output;
    }

    public function guardarOficinaOrden()
    {
        $id_cart = $this->_checkoutSession->getQuote()->getId();

        $mensaje = $_POST['texto_oficina'];
        $mensajeExplode = explode('#!#', $mensaje);
        $numOficina = $mensajeExplode[0];
        $direccionOfi = $mensajeExplode[1];
        $oficina = $mensajeExplode[2];
        $poblacionCP = $mensajeExplode[4] . "/" . $mensajeExplode[3];

        $OfficedeliverycorreoDTO = $this->cexOfficedeliverycorreoFactory->create();
        $OfficedeliverycorreoDTO->setIdCart($id_cart);
        $OfficedeliverycorreoDTO->setCodigoOficina($numOficina);
        $OfficedeliverycorreoDTO->setTextoOficina($mensaje);

        $this->cexOfficedeliverycorreoRepository->save($OfficedeliverycorreoDTO);

        $html = " <div id='infoOficinas'>
        <h2 class='display-5 bg-dark text-white'>Oficina Seleccionada</h2> 
        <ul class='list-group list-group-flush small'>
        <li class='list-group-item small'>Codigo Oficina: " . $numOficina . "</li>
        <li class='list-group-item small'>Oficina: " . $oficina . "</li>
        <li class='list-group-item small'>Dirección Oficina: " . $direccionOfi . "</li>
        <li class='list-group-item small'>Población/CP: " . $poblacionCP . "</li>
        </ul>
        </div>
        <div id='contenedorBoton h-25 align-bottom'>
        <button id='botonBuscador' class='CEX-btn CEX-button-yellow mt-2' onclick='abrirModal();'>
        Cambiar Oficina
        </button>
        </div>";
        echo $html;
    }

    public function abrirModal()
    {
        $rutaLogo = 'CorreosExpress_RegistroDeEnvios::images/correosexpress.png';
        $asset = $this->_assetRepo->createAsset($rutaLogo);
        $path = $asset->getUrl($rutaLogo);
        $html = "<h1 class='my-auto CEX-text-blue w-75 d-inline-block'>
                    <strong>Buscador de Oficinas</strong>
                </h1>
                <img  class='img-fluid w-25' src=" . $path . " />";
        echo $html;
    }

}