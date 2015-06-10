<?php

/**
 * @author Samier Sompura <samier.sompura@wamasoftware.com>
 * @link http://www.wamasoftware.com
 */

namespace Datatabledemo\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\InputFilter\InputFilter,
    Zend\Validator,
    Zend\Session\Container,
    Simpleimage\Controller\Simpleimage;

/**
 * Files Controller
 */
class DatatabledemoController extends AbstractActionController
{
	
        public function indexAction()
	{
          // $productModel = $this->getServiceLocator()->get('Datatabledemo\Model\product');
          //  $productList = $productModel->GetAllProductDetails();
          //  echo '<pre>'; print_r($productList); exit;
        }
        
        public function productAction()
        {
            if ($this->getRequest()->isXmlHttpRequest())
            {
                $dt = $this->getServiceLocator()->get('Datatable\Service\Datatables');

                $checkBox = '<input type="checkbox" name="selectedContact[]" class="selectContact" value="$1" style="margin-left:24px;" onClick="selectContact()">';
                $action = '<a href="javascript:void(0);" title="Delete" onclick="deleteProduct($1);">Delete</a>';

                echo $dt->select('p.Id,p.name,p.qty')
                            ->from('Datatabledemo\Model\Entity\product','p')
                            ->edit_column('p.Id',$checkBox,'p.Id')
                            ->edit_column('p.name','$1','p.name')
                            ->edit_column('p.qty','$1','p.qty')
                            ->add_column('p.Id',$action,'p.Id')
                            //->edit_column('p.Id','$1','p.Id')
                            ->generate();
                exit;
            }
        }
        
        public function deleteproductAction() 
        {
            if ($this->getRequest()->isXmlHttpRequest())
            {
                $post = $this->getRequest()->getPost();
                if(!empty($post['productId']))
                {  
                    $productModel = $this->getServiceLocator()->get('Datatabledemo\Model\product');
                    
                    if(strpos($post['productId'],',') == true)
                        $post['productId'] = explode(',',$post['productId']);
                    
                    $productList = $productModel->deleteProducts($post['productId']);
                    
                    $data['status'] = 'success';
                }
                else
                {
                    $data['status'] = 'error';
                }
                return $this->getResponse()->setContent(json_encode($data));
            }
        }
}
