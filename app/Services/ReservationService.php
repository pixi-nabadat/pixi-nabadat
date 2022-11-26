<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Center;
use App\Models\User;
use App\Models\ReservationHistory;
use App\QueryFilters\ReservationsFilter;
use Exception;

use App\QueryFilters\CentersFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
class ReservationService extends Controller
{

    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $reservations = Reservation::query()->with($withRelation);
        return $reservations->filter(new ReservationsFilter($where_condition));
    }
    public function store(array $data = [])
    {
        $data['customer_id'] = isset($data['customer_id']);
        $data['center_id']   = isset($data['center_id']);
        $data['check_date']  = isset($data['check_date']);
        $data['qr_code']     = uniqid();

        $reservation = Reservation::create($data);
        if (!$reservation)
            return false;

        return $reservation;
    }
    
    public function update(int $reservationId, array $reservationData): bool
    {
        $reservation = $this->find($reservationId);
        if ($reservation) {
            $reservation->update($reservationData);
        }
        return false;
    }
    public function find($id, $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $reservation = Reservation::with($with)->find($id);
        if ($reservation)
            return $reservation;
        return false;
    }
    //we will use it in reservation status
    public function changeStatus($id)
    {
        $center = Center::find($id);
        $center->is_active = !$center->is_active;
        return $center->save();
    }
    public function delete($id): bool
    {
        $reservation = $this->find($id);
        if ($reservation) {
            return $reservation->delete();
        }
        return false;
    }
    ////////////////////////////////////////////
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     return Reservation::all();
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     try{
    //         return Center::all();
    //     }catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  array  $reservationData
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(array $reservationData)
    // {
    //     try{
    //         $reservation = Reservation::create($reservationData);
    //         $history = new ReservationHistory([
    //             'action_en' => Reservation::pending('en'),
    //             'action_ar' => Reservation::pending('ar')
    //         ]);
    //         $reservation->history()->save($history);
    //         return $reservation;
    //     }catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  Reservation  $Reservation
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Reservation $reservation)
    // {
    //     try{
    //         return $reservation;
    //     }catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  Reservation  $reservation
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Reservation $reservation)
    // {
    //     try{
    //         return $reservation;
    //     }catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  Reservation  $reservation
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(array $reservationData, Reservation $reservation, string $newAction)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  Reservation  $reservation
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Reservation $reservation)
    // {
    //     try{
    //         $reservation->delete();
    //         return true;
    //     }catch(Exception $e){
    //         return $e->getMessage();
    //     }
    // }

    // public function confirm(User $user, Reservation $reservation){
    //     try{
    //         $lastStatus = $reservation->history->last()->action_en;
    //         if($lastStatus == Reservation::pending('en')){
    //             $reservation->history()->create([
    //                 'user_id'=>$user->id,
    //                 'action_en'=>Reservation::confirm('en'),
    //                 'action_ar'=>Reservation::confirm('ar')
    //             ]);
    //             return true;
    //         }else{
    //             throw new StatusNotEquelException('the status is: '.$lastStatus);
    //         }
            
            
    //     }catch(Exception $e){
    //         throw $e;
    //     }
    // }
    // public function attend(User $user, Reservation $reservation){
    //     try{
    //         $lastStatus = $reservation->history->last()->action_en;
    //         if($lastStatus == Reservation::confirm('en')){
    //             $reservation->history()->create([
    //                 'user_id'=>$user->id,
    //                 'action_en'=>Reservation::attend('en'),
    //                 'action_ar'=>Reservation::attend('ar')
    //             ]);
    //             return true;
    //         }else{
    //             throw new StatusNotEquelException('the status is: '.$lastStatus);
    //         }

    //     }catch(Exception $e){
    //         throw $e;
    //     }
    // }
    // public function complete(User $user, Reservation $reservation){
    //     try{
    //         $lastStatus = $reservation->history->last()->action_en;
    //         $reservationDevicesCount = $reservation->nabadatHistory->count();
    //         if($lastStatus == Reservation::attend('en') && $reservationDevicesCount > 0){
    //             $reservation->history()->create([
    //                 'user_id'=>$user->id,
    //                 'action_en'=>Reservation::completed('en'),
    //                 'action_ar'=>Reservation::completed('ar')
    //             ]);
    //             return true;
    //         }else{
    //             throw new StatusNotEquelException('status is: '.$lastStatus.' and devices is: '.$reservationDevicesCount);
    //         }

    //     }catch(Exception $e){
    //         throw $e;
    //     }
    // }
    // public function reservationDevices(array $data, Reservation $reservation){
    //     try{

    //     }catch(Exception $e){
    //         throw $e;
    //     }

    // }
    // public function cancel(User $user, Reservation $reservation)
    // {
    //     try{
    //         $lastStatus = $reservation->history->last()->action_en;
    //         if($lastStatus != Reservation::completed('en') && $lastStatus != Reservation::canceled('en') && $lastStatus != Reservation::expired('en')){
    //             $reservation->history()->create([
    //                 'user_id'=>$user->id,
    //                 'action_en'=>Reservation::canceled('en'),
    //                 'action_ar'=>Reservation::canceled('ar')
    //             ]);
    //             return true;
    //         }else{
    //             throw new StatusNotEquelException('the status is: '.$lastStatus);
    //         }
                        
    //     }catch(Exception $e){
    //         throw $e;
    //     }
    // }

}
