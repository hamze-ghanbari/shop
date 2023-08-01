<?php

namespace Modules\Auth\Repository;

use App\Repository\Eloquent\BaseRepository;
use Modules\Auth\Entities\Otp;

class OtpRepository extends BaseRepository implements OtpRepositoryInterface
{

    public function model()
    {
        return Otp::class;
    }

}
