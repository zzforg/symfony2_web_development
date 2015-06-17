<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CRUDController
 *
 * @author jw
 */

namespace Ibase\StoreBundle\Controller;
 
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery as ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PurchaseAdminController extends Controller {
    public function batchActionToPaid(ProxyQueryInterface $selectedModelQuery)
    {
        if ($this->admin->isGranted('EDIT') === false || 
                $this->admin->isGranted('DELETE') === false) 
        {
            throw new AccessDeniedException();
        }

        $modelManager = $this->admin->getModelManager();

        $selectedModels = $selectedModelQuery->execute();

        try {
            foreach ($selectedModels as $selectedModel) {
                $selectedModel['status'] = 'paid';
                $modelManager->update($selectedModel);
            }
        } catch (\Exception $e) {
            $this->get('session')
                    ->getFlashBag()
                    ->add('sonata_flash_error', $e->getMessage());

            return new RedirectResponse(
                    $this->admin->generateUrl(
                            'list',
                            $this->admin->getFilterParameters()
                            )
                    );
        }

        $this->get('session')
                ->getFlashBag()
                ->add('sonata_flash_success', 
                        sprintf(
                            'The selected jobs validity has been extended until %s.', 
                            date('m/d/Y', time() + 86400 * 30)
                        )
                     );

        return new RedirectResponse(
                $this->admin->generateUrl(
                        'list',$this->admin->getFilterParameters()
                        )
                );
    }
    
    public function batchActionToShipped(ProxyQueryInterface $selectedModelQuery)
    {
        if ($this->admin->isGranted('EDIT') === false 
                || $this->admin->isGranted('DELETE') === false) 
        {
            throw new AccessDeniedException();
        }

        $modelManager = $this->admin->getModelManager();

        $selectedModels = $selectedModelQuery->execute();

        try {
            foreach ($selectedModels as $selectedModel) {
                $selectedModel['status'] = 'shipped';
                $modelManager->update($selectedModel);
            }
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->add('sonata_flash_error', $e->getMessage());

            return new RedirectResponse($this->admin->generateUrl('list',$this->admin->getFilterParameters()));
        }

        $this->get('session')->getFlashBag()->add('sonata_flash_success',  sprintf('The selected jobs validity has been extended until %s.', date('m/d/Y', time() + 86400 * 30)));

        return new RedirectResponse($this->admin->generateUrl('list',$this->admin->getFilterParameters()));
    }
}
