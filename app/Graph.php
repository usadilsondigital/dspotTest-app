<?php

namespace App;

use App\Models\Profile;
use SplDoublyLinkedList;
use SplQueue;

class Graph
{
    protected $graph;
    protected $visited = array();

    public function __construct($graph)
    {
        $this->graph = $graph;
    }

    public function breadthFirstSearch($origin, $destination)
    {
        foreach ($this->graph as $vertex => $adj) {
            $this->visited[$vertex] = false;
        }
        $q = new SplQueue();
        $q->enqueue($origin);
        $this->visited[$origin] = true;
        $path = array();
        $path[$origin] = new SplDoublyLinkedList();
        $path[$origin]->setIteratorMode(
            SplDoublyLinkedList::IT_MODE_FIFO | SplDoublyLinkedList::IT_MODE_KEEP
        );
        $path[$origin]->push($origin);
        $found = false;
        while (!$q->isEmpty() && $q->bottom() != $destination) {
            $t = $q->dequeue();
            if (!empty($this->graph[$t])) {
                foreach ($this->graph[$t] as $vertex) {
                    if (!$this->visited[$vertex]) {
                        $q->enqueue($vertex);
                        $this->visited[$vertex] = true;
                        $path[$vertex] = clone $path[$t];
                        $path[$vertex]->push($vertex);
                    }
                }
            }
        }
        $message = "";

        if (isset($path[$destination])) {
            $message .=   "The shorter connection between $origin and $destination: ";
           
            $sep = '';
            if (count($path[$destination]) == 1) {
                $message .=   "The connection is himself";
            } else {
                if (count($path[$destination]) == 2) {
                    $message .=   "Direct connection";
                } else {
                    $i = 1;
                    foreach ($path[$destination] as $vertex) {                       
                        if ($i == 1) {
                            $message .=   "[";
                        } else {
                            if ($i == count($path[$destination])) {
                                $message .=  "]";
                            } else {
                                $pId = Profile::where('first_name', $vertex)->first();
                                $message .=  $sep." ". $vertex . " - " . $pId->id;
                                $sep = ' -> ';
                            }
                        }
                        $i++;
                    }
                }
            }
        } else {
            $message .=  "No route";
        }
        return $message;
    }
}
