import { TextField } from "@mui/material";
import { Controller } from "react-hook-form";
import Section from "@/components/EditProfilePage/Section";
import { useFormContext } from "react-hook-form";

const ResetPasswordForm = () => {
  const { watch, control, formState: { errors } } = useFormContext();
  const newPassword = watch("new_password");

  return (
    <Section title="Reset password">
      <Controller
        name={"new_password"}
        control={control}
        rules={{
          minLength: {
            value: 8,
            message: "Password must be at least 8 characters",
          },
        }}
        render={({ field }) => (
          <TextField
            size="small"
            type="password"
            label={"New password"}
            value={field.value}
            onChange={field.onChange}
            sx={{ flex: 1 }}
            error={!!errors.new_password}
            helperText={errors.new_password ? errors.new_password.message : ""}
          />
        )}
      />
      <Controller
        name={"confirm_password"}
        control={control}
        rules={{
          validate: value =>
            value === newPassword || "Passwords do not match",
        }}
        render={({ field }) => (
          <TextField
            size="small"
            type="password"
            label={"Confirm password"}
            value={field.value}
            onChange={field.onChange}
            sx={{ flex: 1 }}
            error={!!errors.confirm_password}
            helperText={errors.confirm_password ? errors.confirm_password.message : ""}
          />
        )}
      />
    </Section>
  );
};

export default ResetPasswordForm;