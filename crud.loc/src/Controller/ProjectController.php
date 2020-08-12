<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends AbstractController
{
    /**
     * @param ProjectRepository $projectRepository
     * @return JsonResponse
     */
    public function getList(ProjectRepository $projectRepository)
    {
        $list = $projectRepository->findAll();

        if (!$list){
            $data = [
                'status' => 200,
                'errors' => "List empty!",
            ];
            return $this->response($data, 404);
        }
        return $this->response($list);
    }

    /**
     * @param ProjectRepository $projectRepository
     * @param $id
     * @return JsonResponse
     */
    public function getListById(ProjectRepository $projectRepository, $id)
    {
        $list = $projectRepository->find($id);

        if (!$list){
            $data = [
                'status' => 404,
                'errors' => "Project not found",
            ];
            return $this->response($data, 404);
        }
        return $this->response($list);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    public function addProject(Request $request, EntityManagerInterface $em)
    {
        try{
            $request = $this->transformJsonBody($request);

            if (
                !$request
                || !$request->get('name')
                || !$request->request->get('code')
                || !$request->request->get('url')
                || !$request->request->get('budget')
            ){
                throw new \Exception();
            }

            $success = self::addContact($request, $em);

            if ($success['status']){

                $project = new Project();
                $project->setName($request->get('name'));
                $project->setCode($request->get('code'));
                $project->setUrl($request->get('url'));
                $project->setBudget($request->get('budget'));
                $project->setContacts($success['contact']);
                $em->persist($project);
                $em->flush();

                return $this->response($project);

            } else {
                throw new \Exception();
            }
        }catch (\Exception $e){
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 422);
        }
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return array
     */
    private function addContact(Request $request, EntityManagerInterface $em)
    {
        try{
            $success = [
                'status'    => false,
                'contact'   => (object) null,
            ];
            $request    = $this->transformJsonBody($request);
            $arrContact = current($request->get('contacts'));

            if (
                !$arrContact
                || !$arrContact['firstName']
                || !$arrContact['lastName']
                || !$arrContact['phone']
            ){
                return $success;
            }

            $contact = new Contact();
            $contact->setFirstName($arrContact['firstName']);
            $contact->setLastName($arrContact['lastName']);
            $contact->setPhone($arrContact['phone']);
            $em->persist($contact);
            $em->flush();

            $success['status']  = true;
            $success['contact'] = $contact;

            return $success;

        }catch (\Exception $e){
            return $success;
        }
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ProjectRepository $projectRepository
     * @param $id
     * @return JsonResponse
     */
    public function updProject(Request $request, EntityManagerInterface $em, ProjectRepository $projectRepository, $id)
    {
        try{
            $project = $projectRepository->find($id);

            if (!$project){
                $data = [
                    'status' => 404,
                    'errors' => "Project not found",
                ];
                return $this->response($data, 404);
            }

            $request = $this->transformJsonBody($request);

            if (!$request || !$request->get('name')){
                throw new \Exception();
            }

            $project->setName($request->get('name'));
            $em->flush();

            return $this->response($project);

        }catch (\Exception $e){
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
            ];
            return $this->response($data, 422);
        }
    }

    /**
     * @param EntityManagerInterface $em
     * @param ProjectRepository $projectRepository
     * @param $id
     * @return JsonResponse
     */
    public function delProject(EntityManagerInterface $em, ProjectRepository $projectRepository, $id){
        $project = $projectRepository->find($id);

        if (!$project){
            $data = [
                'status' => 404,
                'errors' => "Project not found",
            ];
            return $this->response($data, 404);
        }

        $em->remove($project);
        $em->flush();

        $data = [
            'status' => 200,
            'errors' => "Project deleted successfully",
        ];
        return $this->response($data);
    }


    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
